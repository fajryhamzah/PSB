<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Ujian;
use App\Models\Setting;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

class UjianCont extends Controller
{
    private $parser = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function addView(){
      $data = array();
      $data["username"] = \Session::get("username");
      $data["sisa"] = 100 - Ujian::select(\DB::raw('SUM(persentase) AS total'))->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->first()->total;

      return view('dashboard.content.addUjian',$data);
    }

    public function add(Request $r){
      $rules = array(
          'nama_ujian' => 'required',
          'persentase' => 'required|numeric|min:1'
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/ujian/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $user = new Ujian;
      $user->nama_ujian = $r->input("nama_ujian");
      $user->persentase = $r->input("persentase");
      $user->tahun_ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];

      $sisa = 100 - Ujian::select(\DB::raw('SUM(persentase) AS total'))->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->first()->total;

      if($user->persentase > $sisa){
        return \Redirect::to(url("/dashboard/ujian/add"))->with(["error" => "Persentase akan melebihi 100"]);
      }

      try{
        $user->save();
        return \Redirect::to(url("/dashboard/ujian"))->with(["success" => "Daftar berhasil"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/ujian/add"))->with(["error" => "nama ujian sudah terdaftar"]);
      }

    }

    public function delete($id){
      $model = Ujian::find($id);

      if($model->delete()){
        return \Redirect::to(url("/dashboard/ujian"))->with(["success" => "Berhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/ujian"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

    public function edit($id){
      $model = Ujian::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/ujian"))->with(["error" => "Pekerjaan tidak ditemukan"]);
      }

      $data = array();
      $data["nama_ujian"] = $model->nama_ujian;
      $data["persentase"] = $model->persentase;
      $data["username"] = \Session::get("username");
      $data["id"] = $id;
      $data["sisa"] = 100 - Ujian::select(\DB::raw('SUM(persentase) AS total'))->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->first()->total;

      return view('dashboard.content.editUjian',$data);
    }

    public function editSave(Request $r){
      $rules = array(
        'nama_ujian' => 'required',
        'persentase' => 'required|numeric'
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/ujian/edit/".$r->input("id")))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }
      $model = Ujian::find($r->input("id"));
      $lama = $model->persentase;

      $model->nama_ujian = $r->input("nama_ujian");
      $model->persentase = $r->input("persentase");

      $sisa = Ujian::select(\DB::raw('SUM(persentase) AS total'))->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->first()->total;

      if(($model->persentase > $sisa-$lama) ){
        return \Redirect::to(url("/dashboard/ujian/edit/".$r->input("id")))->with(["error" => "Persentase akan melebihi 100"]);
      }

      try{
        if($model->save()){
          return \Redirect::to(url("/dashboard/ujian"))->with(["success" => "berhasil diedit"]);
        }
        else{
          return \Redirect::to(url("/dashboard/ujian/edit/".$r->input("id")))->with(["error" => "Terjadi kesalahan"]);
        }
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/ujian/edit/".$r->input("id")))->with(["error" => "nama ujian sudah terdaftar"]);
      }
    }


}
