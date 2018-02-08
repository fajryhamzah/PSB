<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Ujian;
use App\Models\Persyaratan;
use App\Models\Prestasi;
use App\Models\Pekerjaan;
use App\Models\Setting;
use App\Models\No_telp;
use App\Models\No_telp_ibu;
use App\Models\No_telp_ayah;
use App\Models\Detail_siswa as Detail;
use App\Models\Nilai_ujian as Nilai;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Carbon\Carbon;

class Penilai extends Controller
{
    private $parser = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function add(Request $r){
      $rules = array(
          'username' => 'required|min:5', // username
          'password' => 'required|alphaNum|min:5', // password
          'email' => 'required|email',
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/penilai/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $username = $r->input("username");
      $password = $r->input("password");
      $email = $r->input("email");
      $status = $r->input("status");

      $user = new User;
      $user->username = $username;
      $user->password = md5($password);
      $user->email = $email;
      $user->aktif = 1;
      $user->id_tipe = 2;
      $user->tgl_daftar = date('Y-m-d');
      $user->tahun_ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];

      try{
        $user->save();
        return \Redirect::to(url("/dashboard/penilai"))->with(["success" => "Daftar berhasil"]);
      }
      catch(\Exception $e){
        $msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/penilai/add"))->with(["error" => "Username/email telah terpakai".$msg]);
      }

    }

    public function delete($id){
      $model = User::find($id);

      if($model->id_tipe != 2){
        return \Redirect::to(url("/dashboard/penilai"))->with(["error" => "Ihh nakal ya.."]);
      }

      if($model->delete()){
        return \Redirect::to(url("/dashboard/penilai"))->with(["success" => "Akun berhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/penilai"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

    public function edit($id){
      $model = User::select(["username","email","id_tipe"])->find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/penilai"))->with(["error" => "User tidak ditemukan"]);
      }

      if($model->id_tipe != 2){
        return \Redirect::to(url("/dashboard/penilai"))->with(["error" => "Ihh nakal ya.."]);
      }

      $data = array();
      $data["username"] = $model->username;
      $data["id"] = $id;
      $data["email"] = $model->email;

      return view('dashboard.content.editPenilai',$data);
    }

    public function editSave(Request $r){
      $rules = array(
          'username' => 'required|min:5', // username
          'password' => 'nullable|alphaNum|min:5', // password
          'email' => 'required|email',
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/penilai/edit/".$r->input("id")))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }
      $model = User::find($r->input("id"));

      if($model->id_tipe != 2){
        return \Redirect::to(url("/dashboard/penilai"))->with(["error" => "Ihh nakal ya.."]);
      }

      $model->username = $r->input("username");
      $model->email = $r->input("email");
      if($r->input("password") != ""){
        $model->password = md5($r->input("password"));
      }

      try{
        if($model->save()){
          return \Redirect::to(url("/dashboard/penilai"))->with(["success" => "Akun berhasil diedit"]);
        }
        else{
          return \Redirect::to(url("/dashboard/penilai/edit/".$r->input("id")))->with(["error" => "Terjadi kesalahan"]);
        }
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/penilai/edit/".$r->input("id")))->with(["error" => "username/email sudah terdaftar"]);
      }
    }

    public function addList(Request $r){
      $data = array();
      $data["username"] = \Session::get("username");
      $data['ujian'] = Ujian::all()->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"]);
      return view('dashboard.penilai.content.addList',$data);
    }

    public function addListSave(Request $r){
      $rules = array(
          'ujian' => 'required|numeric',
          'nodaftar' => 'required|numeric',
          'nilai' => 'required|numeric',
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/list_nilai/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $user = User::find($r->input("nodaftar"))->where("id_tipe",3)->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->toSql();

      if(!$user){
        return \Redirect::to(url("/dashboard/list_nilai/add"))->with(["error" => "No daftar salah"]);
      }


      $user = new Nilai;
      $user->id_ujian = $r->input("ujian");
      $user->id_penilai = \Session::get("id");
      $user->id_siswa = $r->input("nodaftar");
      $user->nilai = $r->input("nilai");

      try{
        $user->save();
        return \Redirect::to(url("/dashboard/list_nilai"))->with(["success" => "Tambah berhasil"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/list_nilai/add"))->with(["error" => "Ujian dan siswa yang dipilih sudah dinilai"]);
      }
    }

    public function deleteList($id){
      $model = Nilai::find($id);

      if($model->id_penilai != \Session::get("id")){
        return \Redirect::to(url("/dashboard/list_nilai"))->with(["error" => "Anda tidak mempunyai hak"]);
      }

      if($model->delete()){
        return \Redirect::to(url("/dashboard/list_nilai"))->with(["success" => "Data berhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/list_nilai"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

    public function editList($id){
      $model = Nilai::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/list_nilai"))->with(["error" => "Nakal ya..."]);
      }

      if($model->id_penilai != \Session::get("id")){
        return \Redirect::to(url("/dashboard/list_nilai"))->with(["error" => "Anda tidak mempunyai hak"]);
      }

      $data = array();
      $data["username"] = \Session::get("username");
      $data["ujian_select"] = $model->id_ujian;
      $data['ujian'] = Ujian::all()->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"]);
      $data["nodaftar"] = $model->id_siswa;
      $data["nilai"] = $model->nilai;

      return view('dashboard.penilai.content.editList',$data);
    }

    public function editListSave(Request $r){

        $rules = array(
            'ujian' => 'required|numeric',
            'nodaftar' => 'required|numeric',
            'nilai' => 'required|numeric',
        );

        $validator = \Validator::make($r->all(), $rules);

        if($validator->fails()){
            return back()->with(["error" => implode("<br>",$validator->errors()->all())]);
        }

        $user = User::find($r->input("nodaftar"))->where("id_tipe",3)->first();

        if(!$user){
          return back()->with(["error" => "No daftar salah"]);
        }

        $user = Nilai::find($r->route("id"));

        if($user->id_penilai != \Session::get("id")){
          return \Redirect::to(url("/dashboard/list_nilai"))->with(["error" => "Anda tidak mempunyai hak"]);
        }

        $user->id_ujian = $r->input("ujian");
        $user->id_penilai = \Session::get("id");
        $user->id_siswa = $r->input("nodaftar");
        $user->nilai = $r->input("nilai");

        try{
          $user->save();
          return \Redirect::to(url("/dashboard/list_nilai"))->with(["success" => "Berhasil diedit"]);
        }
        catch(\Exception $e){
          $msg = $e->getMessage();
          return back()->with(["error" => "Ujian dan siswa yang dipilih sudah ada didatabase".$msg]);
        }
    }

    public function listSiswa(){
      $ujian = Ujian::all();

      $data = array();
      $data["username"] = \Session::get("username");

      $data["ujian"] = $ujian;

      return view('dashboard.penilai.content.listsiswa',$data);
    }

    public function siswaProf($id){
      $data = array();
      $data["username"] = \Session::get("username");
      $data["id"] = $id;
      $model = Detail::find($id);

      if($model){
        $data['nama'] = $model->nama;
        $data['tgl'] = $model->tgl_lahir;
        $data['jk'] = $model->jenis_kelamin;
        $data['alamat'] = $model->alamat;
        $data['asal_sek'] = $model->asal_sekolah;
        $data['notelp'] = implode("|",array_map(function($e){ return $e["no"]; },No_telp::select("no")->where("id",$id)->get()->toArray()));
        $data['nama_ayah'] = $model->nama_ayah;
        $data['alamatayah'] = $model->alamat_ayah;
        $data['notelpayah'] = implode("|",array_map(function($e){ return $e["no"]; },No_telp_ayah::select("no")->where("id",$id)->get()->toArray()));
        $data['nama_ibu'] = $model->nama_ibu;
        $data['alamatibu'] = $model->alamat_ibu;
        $data['notelpibu'] = implode("|",array_map(function($e){ return $e["no"]; },No_telp_ibu::select("no")->where("id",$id)->get()->toArray()));
        $data['stat'] = $model->status_orangtua;

        try{
          $data["pek_ayah"] = Pekerjaan::where("id_pekerjaan",$model->id_pekerjaan_ayah)->first()->nama_pekerjaan;
        }
        catch(\Exception $e){
          $data["pek_ayah"] = "-";
        }

        try{
          $data['pek_ibu'] = Pekerjaan::where("id_pekerjaan",$model->id_pekerjaan_ibu)->first()->nama_pekerjaan;
        }
        catch(\Exception $e){
          $data["pek_ibu"] = "-";
        }

      }
      else{
        $data['nama'] = "-";
        $data['tgl'] = "0000-00-00";
        $data['jk'] = "-";
        $data['alamat'] = "-";
        $data['asal_sek'] = "-";
        $data['notelp'] = "-";
        $data['nama_ayah'] = "-";
        $data['alamatayah'] = "-";
        $data['notelpayah'] = "-";
        $data['nama_ibu'] = "-";
        $data['alamatibu'] = "-";
        $data['notelpibu'] = "-";
        $data['stat'] = "-";
        $data["pek_ayah"] = "-";
        $data['pek_ibu'] = "-";
      }

      $data['umur'] = Carbon::parse(date_format(new \DateTime($data['tgl']),'Y-m-d'))->age;

      $persyaratan = Persyaratan::find($id);
      $data['foto'] = (!isset($persyaratan->foto))? "no.png": $persyaratan->foto;

      return view('dashboard.penilai.content.profileSiswa',$data);
    }

    public function prestasiServer($id){
        $users = Prestasi::select("id_prestasi as id","nama_prestasi","id_penilai")->where("id",$id)->get();

        return Datatables::of($users)->addColumn('action', function($users){
          if(!$users->id_penilai){
            $ret = " <a href='".url('/dashboard/prestasi/nilai')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Nilai Prestasi</button></a>";

          }
          else{
            $ret = "Prestasi sudah dinilai";
          }
          return $ret;
        })->removeColumn("id")->removeColumn("id_penilai")->make();
    }

    public function nilaiPrestasi($id){
      $data = array();
      $data["username"] = \Session::get("username");
      $data["id"] = $id;
      $model = Prestasi::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/list_pendaftar/check/".$id));
      }

      $data["nama"] = $model->nama_prestasi;
      $data["det"] = $model->keterangan;
      $data["dokname"] = "";
      if($model->dokumen){
        $data["dok"] = asset("/img/dokumen/")."/".User::find($model->id)->username."/".$model->dokumen;
        $data["dokname"] = $model->dokumen;
      }

      return view('dashboard.penilai.content.nilai_prestasi',$data);
    }

    public function nilaiPrestasiSave(Request $r){
      $rules = array(
          'id' => 'required|numeric',
          'nilai' => 'required|numeric',
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return back()->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $model = Prestasi::find($r->input("id"));

      $model->id_penilai = \Session::get("id");
      $model->nilai = $r->input("nilai");

      try{
        $model->save();
        return \Redirect::to(url("/dashboard/list_prestasi"))->with(["success" => "Berhasil dinilai"]);
      }
      catch(\Exception $e){
        $msg = $e->getMessage();
        return back()->with(["error" => "Database Error: ".$msg]);
      }
    }

    public function listPrestasi(){
      $data = array();
      $data["username"] = \Session::get("username");

      return view('dashboard.penilai.content.list_prestasi',$data);
    }

    public function listPrestasiSudahDiNilai(){
      $id = \Session::get("id");
      $users = Prestasi::select("id_prestasi as id","nama_prestasi","id_penilai")->where("id_penilai",$id)->get();



      return Datatables::of($users)->addColumn('action', function($users){
        $ret = " <a href='".url('/dashboard/prestasi/nilai/edit')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
        $ret .= " <button class='hapus' onclick=\"showModal('".url('/dashboard/prestasi/nilai/delete')."/".$users->id."','".$users->nama_prestasi."')\"><i class='material-icons icon-align'>create</i>Delete</button>";

        return $ret;
      })->removeColumn("id")->removeColumn("id_penilai")->make();
    }

    public function listPrestasiSemua(){
      $id = \Session::get("id");
      $users = Prestasi::select("id_prestasi as id","nama_prestasi")->leftJoin("user as a","a.id","prestasi.id")->where("id_penilai",null)->where("a.tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->get();

      return Datatables::of($users)->addColumn('action', function($users){
        $ret = " <a href='".url('/dashboard/prestasi/nilai')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Nilai</button></a>";

        return $ret;
      })->removeColumn("id")->make();
    }

    public function hapusPrestasiNilai($id){
      $model = Prestasi::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/list_prestasi"))->with(["error" => "Penilaian tidak ditemukan"]);
      }

      if($model->id_penilai != \Session::get("id")){
        return \Redirect::to(url("/dashboard/list_prestasi"))->with(["error" => "Penilaian milik penilai lainnya"]);
      }
      $model->id_penilai = null;
      $model->nilai = null;
      try{
        $model->save();
        return \Redirect::to(url("/dashboard/list_prestasi"))->with(["success" => "Penilaian berhasil dihapus"]);
      }
      catch(\Exception $e){
        $msg = $e->getMessage();
        return back()->with(["error" => "Database Error: ".$msg]);
      }
    }

    public function nilaiPrestasiEdit($id){
      $data = array();
      $data["username"] = \Session::get("username");
      $data["id"] = $id;
      $model = Prestasi::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/list_pendaftar/check/".$id));
      }

      $data["nama"] = $model->nama_prestasi;
      $data["det"] = $model->keterangan;
      $data["nilai"] = $model->nilai;
      $data["dokname"] = "";
      if($model->dokumen){
        $data["dok"] = asset("/img/dokumen/")."/".User::find($model->id)->username."/".$model->dokumen;
        $data["dokname"] = $model->dokumen;
      }

      return view('dashboard.penilai.content.edit_nilai_prestasi',$data);
    }


}
