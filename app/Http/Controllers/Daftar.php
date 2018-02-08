<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;

use Illuminate\Http\Request;

class Daftar extends Controller
{
    private $parser = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

     public function indexDaftar(){
       $tgl_mulai = Setting::where("name","tgl_mulai")->first()->toArray()["nilai"];
       $tgl_akhir = Setting::where("name","tgl_selesai")->first()->toArray()["nilai"];
       $tgl_buka = Setting::where("name","tgl_buka")->first()->toArray()["nilai"];
       $kuota = Setting::where("name","kuota")->first()->toArray()["nilai"];
       $ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];
       $data = array();

       if(strtotime("now") < strtotime($tgl_mulai)){
         $data['mulai'] = date("d M Y",strtotime($tgl_mulai));
       }

       if(strtotime("now") > strtotime($tgl_akhir)){
         $data['akhir'] = date("d M Y",strtotime($tgl_akhir));
       }

       $data['tgl_mulai'] = date("d M Y",strtotime($tgl_mulai));
       $data['tgl_akhir'] = date("d M Y",strtotime($tgl_akhir));
       $data['tgl_pembukaan'] = date("d M Y",strtotime($tgl_buka));
       $data['kuota'] = $kuota;
       $data['ajaran'] = $ajaran;

       return view("login",$data);
     }
    public function index(Request $r)
    {
        $tgl_mulai = Setting::where("name","tgl_mulai")->first()->toArray()["nilai"];
        $tgl_akhir = Setting::where("name","tgl_selesai")->first()->toArray()["nilai"];
        $ret = null;
        if(strtotime("now") < strtotime($tgl_mulai)){
          $msg = "Pendaftaran belum dimulai";
          $ret = array('code'=>200,'msg'=> $msg );
        }

        if(strtotime("now") > strtotime($tgl_akhir)){
          $msg = "Pendaftaran telah ditutup";
          $ret = array('code'=>200,'msg'=> $msg );
        }

        if($ret){
          return json_encode($ret);
        }


        $rules = array(
            'username' => 'required|min:5', // username
            'password' => 'required|alphaNum|min:5', // password
            'email' => 'required|email',
            'g-recaptcha-response' => 'required|captcha'
        );

        $validator = \Validator::make($r->all(), $rules);

        if($validator->fails()){
            $ret = array('code'=>403,'msg'=> $validator->errors()->all() );
        }
        else{
          $username = $r->input("username");
          $password = $r->input("password");
          $email = $r->input("email");

          $user = new User;
          $user->username = $username;
          $user->password = md5($password);
          $user->email = $email;
          $user->aktif = 0;
          $user->id_tipe = 3;
          $user->tgl_daftar = date('Y-m-d');
          $user->tahun_ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];

          try{
            $user->save();
            $msg = "Daftar berhasil,hubungi operator untuk mengaktifkan akun";
            $ret = array('code'=>200,'msg'=> $msg );
          }
          catch(\Exception $e){
            //$msg = $e->getMessage();
            $msg = "Username/Email sudah terpakai";
            $ret = array('code'=>403,'msg'=> array($msg) );
          }


        }

        return json_encode($ret);
    }

    public function login(Request $r){
      try{
        $username = $r->input("username");
        $password = md5($r->input("password"));
      }
      catch(\Exception $e){
        return json_encode(array('code'=>403,'msg'=> "username dan password harus diisi" ));
      }


      $data = User::select("id","username","id_tipe","aktif")->where('username', $username)->where('password', $password)->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->first();
      if(is_null($data)){
        return json_encode(array('code'=>403,'msg'=> "username dan password tidak cocok" ));
      }

      if($data->aktif == 0){
        return json_encode(array('code'=>403,'msg'=> "Akun belum diaktifasi, hubungi operator untuk aktifasi" ));
      }

      $thn_ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];

      \Session::put('id', $data->id);
      \Session::put('username', $data->username);
      \Session::put('tipe', $data->id_tipe);
      \Session::put('thn_ajaran', $thn_ajaran);

      return json_encode(array('code'=>200,'msg'=> "Login Berhasil" ));

    }

}
