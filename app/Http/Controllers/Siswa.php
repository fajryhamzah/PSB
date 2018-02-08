<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Detail_siswa;
use App\Models\Persyaratan;
use App\Models\Setting;
use App\Models\Prestasi;
use App\Models\No_telp;
use App\Models\No_telp_ibu;
use App\Models\No_telp_ayah;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;

class Siswa extends Controller
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
          'status' => 'required|boolean'
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/siswa/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $username = $r->input("username");
      $password = $r->input("password");
      $email = $r->input("email");
      $status = $r->input("status");

      $user = new User;
      $user->username = $username;
      $user->password = md5($password);
      $user->email = $email;
      $user->aktif = $status;
      $user->id_tipe = 3;
      $user->tgl_daftar = date('Y-m-d');
      $user->tahun_ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];

      try{
        $user->save();
        $id = $user->id;

        //this is bad, but i dont have enough time, so lets just call it a hack
        try{
          //insert to Detail_siswa
          $ins = new Detail_siswa;
          $ins->id = $id;
          $ins->save();

        }
        catch(\Exception $e){
         //just leave this alone
        }

        try{
          //insert to persyaratan
          $ins = new Persyaratan;
          $ins->id = $id;
          $ins->save();
        }
        catch(\Exception $e){
         //just leave this alone
        }
        return \Redirect::to(url("/dashboard/casis"))->with(["success" => "Daftar berhasil"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/siswa/add"))->with(["error" => "Username/email telah terpakai"]);
      }


    }

    public function activate($id)
    {
      $model = User::find($id);

      if($model->id_tipe != 3){
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Ihh nakal ya.."]);
      }

      $model->aktif = 1;

      if($model->save()){


        //this is bad, but i dont have enough time, so lets just call it a hack
        try{
          //insert to Detail_siswa
          $ins = new Detail_siswa;
          $ins->id = $id;
          $ins->save();

        }
        catch(\Exception $e){
         //just leave this alone
        }

        try{
          //insert to persyaratan
          $ins = new Persyaratan;
          $ins->id = $id;
          $ins->save();
        }
        catch(\Exception $e){
         //just leave this alone
        }



        return \Redirect::to(url("/dashboard/casis"))->with(["success" => "Akun berhasil diaktifkan"]);
      }
      else{
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Terjadi kesalahan"]);
      }

    }

    public function deactivate($id)
    {
      $model = User::find($id);

      if($model->id_tipe != 3){
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Ihh nakal ya.."]);
      }

      $model->aktif = 0;

      if($model->save()){
        return \Redirect::to(url("/dashboard/casis"))->with(["success" => "Akun berhasil dinonaktifkan"]);
      }
      else{
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Terjadi kesalahan"]);
      }

    }

    public function delete($id){
      $model = User::find($id);

      if($model->id_tipe != 3){
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Ihh nakal ya.."]);
      }

      if($model->delete()){
        return \Redirect::to(url("/dashboard/casis"))->with(["success" => "Akun berhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

    public function edit($id){
      $model = User::select(["username","email","aktif","id_tipe"])->find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "User tidak ditemukan"]);
      }

      if($model->id_tipe != 3){
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Ihh nakal ya.."]);
      }



      $data = array();
      $data["username"] = $model->username;
      $data["id"] = $id;
      $data["email"] = $model->email;
      $data["aktif"] = $model->aktif;

      return view('dashboard.content.editSiswa',$data);
    }

    public function editSave(Request $r){
      $rules = array(
          'username' => 'required|min:5', // username
          'password' => 'nullable|alphaNum|min:5', // password
          'email' => 'required|email',
          'status' => 'required|boolean'
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/siswa/edit/".$r->input("id")))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }
      $model = User::find($r->input("id"));

      if($model->id_tipe != 3){
        return \Redirect::to(url("/dashboard/casis"))->with(["error" => "Ihh nakal ya.."]);
      }

      $model->username = $r->input("username");
      $model->email = $r->input("email");
      $model->aktif = $r->input("status");
      if($r->input("password") != ""){
        $model->password = md5($r->input("password"));
      }

      try{
        if($model->save()){
          return \Redirect::to(url("/dashboard/casis"))->with(["success" => "Akun berhasil diedit"]);
        }
        else{
          return \Redirect::to(url("/dashboard/siswa/edit/".$r->input("id")))->with(["error" => "Terjadi kesalahan"]);
        }
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/siswa/edit/".$r->input("id")))->with(["error" => "username/email sudah terdaftar"]);
      }
    }


    public function dataDiri(Request $r){
      $data = array();
      $data["username"] = \Session::get("username");

      $data["pekerjaan"] = Pekerjaan::all()->toArray();
      $model = Detail_siswa::find(\Session::get("id"));

      if($model){
        $data['nama'] = $model->nama;
        $data['tgl'] = $model->tgl_lahir;
        $data['jk'] = $model->jenis_kelamin;
        $data['alamat'] = $model->alamat;
        $data['asal_sek'] = $model->asal_sekolah;
        $data['notelp'] = implode("\n",array_map(function($e){ return $e["no"]; },No_telp::select("no")->where("id",\Session::get("id"))->get()->toArray()));
        $data['nama_ayah'] = $model->nama_ayah;
        $data['alamatayah'] = $model->alamat_ayah;
        $data['notelpayah'] = implode("\n",array_map(function($e){ return $e["no"]; },No_telp_ayah::select("no")->where("id",\Session::get("id"))->get()->toArray()));
        $data['stat_ayah'] = $model->status_ayah;
        $data['nama_ibu'] = $model->nama_ibu;
        $data['alamatibu'] = $model->alamat_ibu;
        $data['notelpibu'] = implode("\n",array_map(function($e){ return $e["no"]; },No_telp_ibu::select("no")->where("id",\Session::get("id"))->get()->toArray()));
        $data['stat_ibu'] = $model->status_ibu;
        $data['id_ayah'] = $model->id_pekerjaan_ayah;
        $data['id_ibu'] = $model->id_pekerjaan_ibu;
      }
      else{
        $data['nama'] = "";
        $data['tgl'] = "";
        $data['jk'] = "";
        $data['alamat'] = "";
        $data['asal_sek'] = "";
        $data['notelp'] = "";
        $data['nama_ayah'] = "";
        $data['alamatayah'] = "";
        $data['notelpayah'] = "";
        $data['nama_ibu'] = "";
        $data['alamatibu'] = "";
        $data['notelpibu'] = "";
        $data['stat_ibu'] = "";
        $data['stat_ayah'] = "";
        $data['id_ayah'] = "";
        $data['id_ibu'] = "";
      }

      return view("dashboard.siswa.content.data_diri",$data);
    }

    public function saveDataDiri(Request $r){
      $rules = array(
          'nama' => 'required',
          'jk' => ['required', \Illuminate\Validation\Rule::in(['l','L','P','p'])],
          'tgl_lahir' => 'required|date',
          'asal_sek' => 'required',
          'alamat' => 'required',
          'nama_ayah' => 'required',
          'alamatayah' => 'required',
          'pk_ayah' => 'required|numeric',
          'nama_ibu' => 'required',
          'alamatibu' => 'required',
          'pk_ibu' => 'required|numeric',
          'stat_ibu' => 'required|boolean',
          'stat_ayah' => 'required|boolean',
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/data_diri"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }
      $model = Detail_siswa::find(\Session::get("id"));

      if(!$model){ //insert
        $model = new Detail_siswa;
      }

      $notelp = explode("\n",$r->input("notelp"));
      $notelp = array_map(function($e){ return ["id"=>\Session::get("id"),"no"=> str_replace("\r","",$e)];},$notelp);
      $notelpibu = explode("\n",$r->input("notelpibu"));
      $notelpibu = array_map(function($e){ return ["id"=>\Session::get("id"),"no"=> str_replace("\r","",$e)];},$notelpibu);
      $notelpayah = explode("\n",$r->input("notelpayah"));
      $notelpayah = array_map(function($e){ return ["id"=>\Session::get("id"),"no"=> str_replace("\r","",$e)];},$notelpayah);
      $model->id = \Session::get("id");
      $model->nama= $r->input("nama");
      $model->tgl_lahir = $r->input("tgl_lahir");
      $model->jenis_kelamin = $r->input("jk");
      $model->alamat = $r->input("alamat");
      $model->asal_sekolah = $r->input("asal_sek");
      $model->nama_ayah = $r->input("nama_ayah");
      $model->alamat_ayah = $r->input("alamatayah");
      $model->id_pekerjaan_ayah = $r->input("pk_ayah");
      $model->nama_ibu = $r->input("nama_ibu");
      $model->alamat_ibu = $r->input("alamatibu");
      $model->id_pekerjaan_ibu = $r->input("pk_ibu");
      $model->status_ibu = $r->input("stat_ibu");
      $model->status_ayah = $r->input("stat_ayah");


      #I'm not proud of this 3 catch block
      try{
        No_telp::where("id",\Session::get("id"))->delete();
        No_telp::insert($notelp);
      }
      catch(\Exception $e){
        if($e->getCode() == 22001){
          return \Redirect::to(url("/dashboard/data_diri"))->with(["error" => "No telp terlalu panjang"]);
        }
      }

      try{
        No_telp_ibu::where("id",\Session::get("id"))->delete();
        No_telp_ibu::insert($notelpibu);
      }
      catch(\Exception $e){
        if($e->getCode() == 22001){
          return \Redirect::to(url("/dashboard/data_diri"))->with(["error" => "No telp ibu terlalu panjang"]);
        }
      }

      try{
        No_telp_ayah::where("id",\Session::get("id"))->delete();
        No_telp_ayah::insert($notelpayah);
      }
      catch(\Exception $e){
        if($e->getCode() == 22001){
          return \Redirect::to(url("/dashboard/data_diri"))->with(["error" => "No telp ayah terlalu panjang"]);
        }
      }

      try{
        if($model->save()){
          return \Redirect::to(url("/dashboard/data_diri"))->with(["success" => "Berhasil disimpan"]);
        }
        else{
          return \Redirect::to(url("/dashboard/data_diri"))->with(["error" => "Terjadi kesalahan"]);
        }
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/data_diri"))->with(["error" => "Terjadi kesalahan ".$e->getMessage()]);
      }
    }

    public function persyaratan(){
      $data = array();
      $data["username"] = \Session::get("username");
      $persyaratan = Persyaratan::find(\Session::get("id"));
      $data['foto'] = (!isset($persyaratan->foto))? "no.png": $persyaratan->foto;
      $data['kk'] = (!isset($persyaratan->kartu_keluarga))? "": $persyaratan->kartu_keluarga;
      $data['skhun'] = (!isset($persyaratan->skhun))? "": $persyaratan->skhun;
      $data['skpk'] = (!isset($persyaratan->surat_keterangan_pindah_kota))? "": $persyaratan->surat_keterangan_pindah_kota;

      return view("dashboard.siswa.content.persyaratan",$data);
    }

    public function persyaratanSave(Request $r){
      $rules = array(
          'foto' => 'image|max:2000',
          'kk' => 'image|max:2000',
          'skhun' => 'image|max:2000',
          'skpk' => 'image|max:2000',
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/persyaratan"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $foto = null;
      $kk = null;
      $skhun = null;
      $skpk = null;
      $id = \Session::get("id");

      $path = public_path()."/img/siswa/";


      if($r->hasFile("foto")){
        $foto = "foto_".$id.".".$r->file("foto")->extension();
        $r->file("foto")->move($path,$foto);
      }

      if($r->hasFile("kk")){
        $kk = "kk_".$id.".".$r->file("kk")->extension();
        $r->file("kk")->move($path,$kk);
      }

      if($r->hasFile("skhun")){
        $skhun = "skhun_".$id.".".$r->file("skhun")->extension();
        $r->file("skhun")->move($path,$skhun);
      }

      if($r->hasFile("skpk")){
        $skpk = "skpk_".$id.".".$r->file("skpk")->extension();
        $r->file("skpk")->move($path,$skpk);
      }

      $model = Persyaratan::find($id);
      if($foto)
        $model->foto = $foto;
      if($kk)
        $model->kartu_keluarga = $kk;
      if($skhun)
        $model->skhun = $skhun;
      if($skpk)
        $model->surat_keterangan_pindah_kota = $skpk;

      if($model->save()){
        return \Redirect::to(url("/dashboard/persyaratan"))->with(["success" => "Persyaratan berhasil diupload"]);
      }
      else{
        return \Redirect::to(url("/dashboard/persyaratan"))->with(["error" => "Database Error"]);
      }
    }

    public function prestasiServer(Request $r){
      $users = Prestasi::select("id_prestasi as id","nama_prestasi")->where("id",\Session::get("id"))->get();

      return Datatables::of($users)->addColumn('action', function($users){
        $ret = "";
        $ret .= " <a href='".url('/dashboard/prestasi/edit')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
        $ret .= " <button class='hapus' onclick=\"showModal('".url("/dashboard/prestasi/delete")."/".$users->id."','".$users->nama_prestasi."')\"><i class='material-icons icon-align'>delete</i>Delete</button>";
        return $ret;
      })->make();
    }

    public function prestasi(){
      $data = array();
      $data["username"] = \Session::get("username");
      $tgl_akhir = Setting::where("name","tgl_tutup_prestasi")->first()->toArray()["nilai"];

      if(strtotime("now") > strtotime($tgl_akhir)){
        $data['selesai'] = date("d M Y",strtotime($tgl_akhir));
      }

      return view("dashboard.siswa.content.prestasi",$data);
    }

    public function prestasiDelete($id){

      $tgl_akhir = Setting::where("name","tgl_tutup_prestasi")->first()->toArray()["nilai"];

      if(strtotime("now") > strtotime($tgl_akhir)){
        return \Redirect::to(url("/dashboard/prestasi"));
      }

      $model = Prestasi::where("id_prestasi",$id)->where("id",\Session::get("id"));

      if($model->delete()){
        return \Redirect::to(url("/dashboard/prestasi"))->with(["success" => "Berhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/prestasi"))->with(["error" => "Database Error"]);
      }
    }

    public function addPrestasi(){
      $tgl_akhir = Setting::where("name","tgl_tutup_prestasi")->first()->toArray()["nilai"];

      if(strtotime("now") > strtotime($tgl_akhir)){
        return \Redirect::to(url("/dashboard/prestasi"));
      }
      $data = array();
      $data["username"] = \Session::get("username");
      return view("dashboard.siswa.content.add_prestasi",$data);
    }

    public function addPrestasiSave(Request $r){
      $tgl_akhir = Setting::where("name","tgl_tutup_prestasi")->first()->toArray()["nilai"];

      if(strtotime("now") > strtotime($tgl_akhir)){
        return \Redirect::to(url("/dashboard/prestasi"));
      }

      $rules = array(
          'dok' => 'nullable|image|max:800',
          'nama' => 'required|min:5',
          "det" => "required"
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/prestasi/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }


      $foto = null;
      if($r->hasFile("dok")){
        $path = public_path()."/img/dokumen/".\Session::get("username")."/";
        $foto = md5(strtotime("now")).".".$r->file("dok")->extension();
        $r->file("dok")->move($path,$foto);
      }

      $model = new Prestasi;
      $model->id = \Session::get("id");
      $model->nama_prestasi = $r->input("nama");
      $model->keterangan = $r->input("det");
      $model->dokumen = $foto;

      try{
        $model->save();
        return \Redirect::to(url("/dashboard/prestasi"))->with(["success" => "Berhasil ditambahkan"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/prestasi/add"))->with(["error" => "Database error"]);
      }

    }

    public function editPrestasi($id){
      $tgl_akhir = Setting::where("name","tgl_tutup_prestasi")->first()->toArray()["nilai"];

      if(strtotime("now") > strtotime($tgl_akhir)){
        return \Redirect::to(url("/dashboard/prestasi"));
      }

      $data = array();
      $model = Prestasi::find($id);

      if(!$model){
        return \Redirect::to(url("/dashboard/prestasi"))->with(["error" => "Prestasi tidak ditemukan"]);
      }
      $data["nama"] = $model->nama_prestasi;
      $data["det"] = $model->keterangan;
      $data["id"] = $model->id_prestasi;
      $data["dokname"] = "";
      if($model->dokumen){
        $data["dok"] = asset("/img/dokumen/")."/".\Session::get("username")."/".$model->dokumen;
        $data["dokname"] = $model->dokumen;
      }

      $data["username"] = \Session::get("username");
      return view("dashboard.siswa.content.edit_prestasi",$data);
    }

    public function editPrestasiSave(Request $r){
      $tgl_akhir = Setting::where("name","tgl_tutup_prestasi")->first()->toArray()["nilai"];

      if(strtotime("now") > strtotime($tgl_akhir)){
        return \Redirect::to(url("/dashboard/prestasi"));
      }

      $rules = array(
          'dok' => 'nullable|image|max:800',
          'nama' => 'required|min:5',
          "det" => "required",
          "id" => "required|numeric"
      );

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/prestasi/add"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $model = Prestasi::find($r->input("id"));

      if(!$model){
        return \Redirect::to(url("/dashboard/prestasi"))->with(["error" => "Prestasi tidak ditemukan"]);
      }

      $model->nama_prestasi = $r->input("nama");
      $model->keterangan = $r->input("det");

      $foto = null;
      if($r->hasFile("dok")){
        $path = public_path()."/img/dokumen/".\Session::get("username")."/";
        \File::delete($path.$model->dokumen);
        $foto = md5(strtotime("now")).".".$r->file("dok")->extension();
        $r->file("dok")->move($path,$foto);
      }

      if($foto){
        $model->dokumen = $foto;
      }

      try{
        $model->save();
        return \Redirect::to(url("/dashboard/prestasi"))->with(["success" => "Berhasil diedit"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/prestasi"))->with(["error" => "Database error"]);
      }

    }


}
