<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

class PekerjaanCont extends Controller
{
    private $parser = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function add(Request $r){
      $rules = array(
          'nama_pekerjaan' => 'required', // username
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/pekerjaan/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $pk = $r->input("nama_pekerjaan");

      $user = new Pekerjaan;
      $user->nama_pekerjaan = $pk;

      try{
        $user->save();
        return \Redirect::to(url("/dashboard/pekerjaan"))->with(["success" => "Daftar berhasil"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/pekerjaan/add"))->with(["error" => "nama_pekerjaan sudah terdaftar"]);
      }

    }

    public function delete($id){
      $model = Pekerjaan::find($id);

      if($model->delete()){
        return \Redirect::to(url("/dashboard/pekerjaan"))->with(["success" => "Bberhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/pekerjaan"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

    public function edit($id){
      $model = Pekerjaan::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/pekerjaan"))->with(["error" => "Pekerjaan tidak ditemukan"]);
      }

      $data = array();
      $data["np"] = $model->nama_pekerjaan;
      $data["username"] = \Session::get("username");
      $data["id"] = $id;

      return view('dashboard.content.editPekerjaan',$data);
    }

    public function editSave(Request $r){
      $rules = array(
          'nama_pekerjaan' => 'required', // username
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/pekerjaan/edit/".$r->input("id")))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }
      $model = Pekerjaan::find($r->input("id"));

      $model->nama_pekerjaan = $r->input("nama_pekerjaan");


      try{
        if($model->save()){
          return \Redirect::to(url("/dashboard/pekerjaan"))->with(["success" => "berhasil diedit"]);
        }
        else{
          return \Redirect::to(url("/dashboard/pekerjaan/edit/".$r->input("id")))->with(["error" => "Terjadi kesalahan"]);
        }
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/pekerjaan/edit/".$r->input("id")))->with(["error" => "nama pekerjaan sudah terdaftar"]);
      }
    }


}
