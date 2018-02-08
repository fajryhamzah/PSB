<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pekerjaan;
use App\Models\Ujian;
use App\Models\Prestasi;
use App\Models\Persyaratan;
use App\Models\Terpilih;
use App\Models\Detail_siswa as Detail;
use App\Models\Nilai_Ujian as Nilai;
use App\Models\Setting;
use Yajra\Datatables\Datatables;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Dashboard extends Controller
{
    private $parser = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $r)
    {
      $data = array();
      $data["username"] = \Session::get("username");
      if(\Session::get("tipe") == 1){
          $data["jumlah_siswa"] = User::where("id_tipe","3")->count();
          $data["not_active"] = User::where("id_tipe","3")->where("aktif",0)->count();
          $data["hari_ini"] = User::where("tgl_daftar",date('Y-m-d'))->count();
          $data["penilai"] = User::where("id_tipe","2")->count();
          return view("dashboard.content.main",$data);
      }
      else if(\Session::get("tipe") == 2){
        $data["prestasi"] = Prestasi::whereNull("id_penilai")->count();
        $data["not_active"] = User::where("id_tipe","3")->where("aktif",0)->count();
        $data["hari_ini"] = User::where("tgl_daftar",date('Y-m-d'))->count();
        $data["penilai"] = User::where("id_tipe","2")->count();

        return view("dashboard.penilai.content.main",$data);
      }
      else{ //siswa
          $data['id'] = \Session::get("id");
          $data['nama'] = Detail::find(\Session::get("id"));
          //dd($data);
          $tgl= Setting::where("name","tgl_buka")->first()->nilai;


          if(strtotime("now") > strtotime($tgl)){
            $data['buka'] = date("d M Y",strtotime($tgl));
            $data['terpilih'] = Terpilih::find(\Session::get("id"));
          }

          //dd($data);
          $data['persyaratan'] = Persyaratan::find(\Session::get("id"));

          return view("dashboard.siswa.content.main",$data);
      }
    }

    public function logout(){
      \Session::flush();
      return \Redirect::to(url("/dashboard"));
    }

    public function casis(Request $r)
    {
        $data = array();
        $data["username"] = \Session::get("username");

        return view("dashboard.content.siswa",$data);

    }

    function data(Request $r){
        $users = User::select(['id', 'username', 'email', 'tgl_daftar','aktif'])->where("id_tipe",3)->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"]);

        return Datatables::of($users)->removeColumn('aktif')->addColumn('action', function($users){
          $ret = "";
          if($users->aktif == 0){
            $ret .= "<a href='".url('/dashboard/siswa/activate')."/".$users->id."'><button class='aktif'><i class='material-icons icon-align'>check</i>Activate</button></a>";
          }
          else{
            $ret .= "<a href='".url('/dashboard/siswa/deactivate')."/".$users->id."'><button class='nonaktif'><i class='material-icons icon-align'>clear</i>Deactivate</button></a>";
          }
          $ret .= " <a href='".url('/dashboard/siswa/edit')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
          $ret .= " <button class='hapus' onclick=\"showModal('".url("/dashboard/siswa/delete")."/".$users->id."','".$users->username."')\"><i class='material-icons icon-align'>delete</i>Delete</button>";
          return $ret;
        })->editColumn('tgl_daftar',function($users){
          return date("d-m-Y", strtotime($users->tgl_daftar));
        })->make();
    }

    public function penilai(Request $r)
    {
        $data = array();
        $data["username"] = \Session::get("username");

        return view("dashboard.content.penilai",$data);
    }

    function datapenilai(Request $r){
        $users = User::select(['id', 'username', 'email'])->where("id_tipe",2)->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"]);

        return Datatables::of($users)->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/penilai/edit')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
          $ret .= " <button class='hapus' onclick=\"showModal('".url("/dashboard/penilai/delete")."/".$users->id."','".$users->username."')\"><i class='material-icons icon-align'>delete</i>Delete</button>";
          return $ret;
        })->make();
    }

    public function pekerjaan(Request $r)
    {
        $data = array();
        $data["username"] = \Session::get("username");

        return view("dashboard.content.pekerjaan",$data);
    }

    function datapekerjaan(Request $r){
        $users = Pekerjaan::all();

        return Datatables::of($users)->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/pekerjaan/edit')."/".$users->id_pekerjaan."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
          $ret .= " <button class='hapus' onclick=\"showModal('".url("/dashboard/pekerjaan/delete")."/".$users->id_pekerjaan."','".$users->nama_pekerjaan."')\"><i class='material-icons icon-align'>delete</i>Delete</button>";
          return $ret;
        })->make();
    }

    public function ujian(Request $r)
    {
        $data = array();
        $data["username"] = \Session::get("username");


        return view("dashboard.content.ujian",$data);
    }

    function dataujian(Request $r){
        $users = Ujian::all()->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"]);

        return Datatables::of($users)->removeColumn("tahun_ajaran")->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/ujian/edit')."/".$users->id_ujian."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
          $ret .= " <button class='hapus' onclick=\"showModal('".url("/dashboard/ujian/delete")."/".$users->id_ujian."','".$users->nama_ujian."')\"><i class='material-icons icon-align'>delete</i>Delete</button>";
          return $ret;
        })->make();
    }

    public function listNilai(Request $r)
    {
        $data = array();
        $data["username"] = \Session::get("username");

        return view("dashboard.penilai.content.listnilai",$data);
    }

    function datalistnilai(Request $r){
        //\DB::enableQueryLog();
        $users = Nilai::select("nilai_ujian.id_nilai_ujian as id","ujian.nama_ujian as ujian","a.username as penilai","user.username as siswa","nilai_ujian.nilai")
        ->join("user", "user.id", "=", "nilai_ujian.id_siswa")
        ->join("ujian", "ujian.id_ujian", "=", "nilai_ujian.id_ujian")
        ->join("user as a", "a.id", "=", "nilai_ujian.id_penilai")
        ->where("a.id",\Session::get("id"))
        ->get();
        //dd(\DB::getQueryLog());

        return Datatables::of($users)->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/list_nilai/edit')."/".$users->id."'><button class='edit'><i class='material-icons icon-align'>create</i>Edit</button></a>";
          $ret .= " <button class='hapus' onclick=\"showModal('".url("/dashboard/list_nilai/delete")."/".$users->id."','Ujian ".$users->ujian." milik ".$users->penilai."')\"><i class='material-icons icon-align'>delete</i>Delete</button>";
          return $ret;
        })->make();
    }

    function setting(Request $r){
      $data = array();
      $data["username"] = \Session::get("username");

      if(\Session::get("tipe") == 1)
      {
        $data["extend"] = "dashboard.index";
        $setting = Setting::all();

        $data["tgl_mulai"] = array_values($setting->where("name","tgl_mulai")->toArray())[0]["nilai"];
        $data["tgl_akhir"] = array_values($setting->where("name","tgl_selesai")->toArray())[0]["nilai"];
        $data["tgl_buka"] = array_values($setting->where("name","tgl_buka")->toArray())[0]["nilai"];
        $data["kuota"] = array_values($setting->where("name","kuota")->toArray())[0]["nilai"];
        $data["thn"] = array_values($setting->where("name","tahun_ajaran")->toArray())[0]["nilai"];
      }
      else if(\Session::get("tipe") == 2)
        $data["extend"] = "dashboard.penilai.index";
      else
        $data["extend"] = "dashboard.siswa.index";

      return view("dashboard.content.setting",$data);
    }

    function settingSave(Request $r){

      if(\Session::get("tipe") == 1)
      {
        $rules = array(
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date',
            'tgl_buka' => 'required|date',
            'kuota' => 'required|numeric|min:1',
            'th' => 'required|numeric|min:1',
            'passbaru' => 'nullable:min:5',
            'passbarukonf' => 'nullable:min:5',
            'passlama' => 'nullable:min:5',
            'restore' => 'nullable|file',
        );
      }
      else{
        $rules = array(
            'passbaru' => 'required|min:5',
            'passbarukonf' => 'required|min:5',
            'passlama' => 'required|min:5'
        );
      }

      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/setting"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }



      $data = array();
      $data["succ"] = "";
      $data["username"] = \Session::get("username");

      if(\Session::get("tipe") == 1){

        if( strtotime($r->input("tgl_mulai")) > strtotime($r->input("tgl_akhir")) ){
            return \Redirect::to(url("/dashboard/setting"))->with(["error" => "Tanggal mulai tidak boleh melebihi tanggal selesai"]);
        }

        if($r->has("restore")){
          if(pathinfo($r->restore->getClientOriginalName(), PATHINFO_EXTENSION)!=='sql'){
              return \Redirect::to(url("/dashboard/setting"))->with(["error" => "File format harus .sql"]);
          }

          \DB::unprepared(file_get_contents($r->file("restore")->getRealPath()));
        }

        $tgl = Setting::find("tgl_mulai");
        $tgl->nilai = $r->input("tgl_mulai");
        $tgl->save();

        $tgl = Setting::find("tgl_selesai");
        $tgl->nilai = $r->input("tgl_akhir");
        $tgl->save();

        $tgl = Setting::find("tgl_buka");
        $tgl->nilai = $r->input("tgl_buka");
        $tgl->save();

        $tgl = Setting::find("kuota");
        $tgl->nilai = $r->input("kuota");
        $tgl->save();

        $tgl = Setting::find("tahun_ajaran");
        $tgl->nilai = $r->input("th");
        $tgl->save();

        $User = User::where("id_tipe",1)->update(array("tahun_ajaran" => $tgl->nilai));



        $data["succ"] .= "Setting berhasil disimpan";
      }

      if($r->input("passbaru") != ""){
        if($r->input("passbaru") != $r->input("passbarukonf")){
          return \Redirect::to(url("/dashboard/setting"))->with(["error" => "Password baru dan password konfirmasi tidak sama"]);
        }

        $model = User::find(\Session::get('id'));

        if(md5($r->input("passlama")) != $model->password){
          return \Redirect::to(url("/dashboard/setting"))->with(["error" => "Password lama salah"]);
        }

        $model->password = md5($r->input("passbaru"));
        $model->save();


        $data["succ"] .= "Password berhasil diganti";
      }
      if(\Session::get("tipe") == 1)
      {
        $data["extend"] = "dashboard.index";
        $setting = Setting::all();
        $data["tgl_mulai"] = array_values($setting->where("name","tgl_mulai")->toArray())[0]["nilai"];
        $data["tgl_akhir"] = array_values($setting->where("name","tgl_selesai")->toArray())[0]["nilai"];
        $data["tgl_buka"] = array_values($setting->where("name","tgl_buka")->toArray())[0]["nilai"];
        $data["kuota"] = array_values($setting->where("name","kuota")->toArray())[0]["nilai"];
        $data["thn"] = array_values($setting->where("name","tahun_ajaran")->toArray())[0]["nilai"];
      }
      else if(\Session::get("tipe") == 2)
        $data["extend"] = "dashboard.penilai.index";
      else
        $data["extend"] = "dashboard.siswa.index";

      return view("dashboard.content.setting",$data);
    }


    function whoisthis(Request $r){

      $nama = "";
      if($r->route("tipe") == "siswa"){
          $model = User::where("id",$r->route("id"))->where("tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])->get()->toArray();

          if($model){
            $model = Detail::select("nama as nm")->where("id",$r->route("id"))->get()->toArray();

            if(!$model){
              $nama = "Bukan siswa atau siswa belum mengisi biodata";
            }
            else{
              $nama = $model[0]['nm'];
            }

            if($r->route("id_ujian")){
              $nilai = Nilai::where("id_ujian",$r->route("id_ujian"))->where("id_siswa",$r->route("id"))->get()->toArray();

              if($nilai){
                $nama = "Ujian yang dipilih sudah dinilai";
              }
            }
          }

      }
      else{
          $model = User::select("username as nm")->where("id",$r->route("id"))->get()->toArray();

          $nama = $model[0]['nm'];
      }


      if($nama != ""){
        return json_encode(["msg"=>$nama]);
      }
      else{
        return json_encode(["msg"=>"Id tidak ditemukan"]);
      }

    }

    function datalistsiswa(){
      $siswa = User::select("user.id","b.nama","c.id_ujian","c.nilai")
               ->leftJoin("nilai_ujian as c","c.id_siswa","user.id")
               ->leftJoin("detail_siswa as b","b.id","user.id")
               ->where("user.id_tipe","3")
               ->where("b.nama","!=",'""')
               ->where("user.tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])
               ->get();

      $data = array();
      $ujian = Ujian::select("id_ujian")->get();
      $dat = array();
      $dat["nama"] = "";
      $dat["id"] = "";

      foreach($ujian as $a){
        $dat["u".$a->id_ujian] = "Belum dinilai";
      }

      foreach($siswa as $a){
          if(empty($data[$a->id])){
            $data[$a->id] = $dat;
          }

          $data[$a->id]["id"] = $a->id;
          $data[$a->id]["nama"] = $a->nama;
          if($a->id_ujian != ""){
            $data[$a->id]["u".$a->id_ujian.""] = $a->nilai;
          }
      }
      $data = array_values($data);

      $data = collect($data);

      return Datatables::of($data)->addColumn("aksi",function($data){
        $ret = "<a href='".url('/dashboard/list_pendaftar/check/')."/".$data['id']."'><button class='edit'><i class='material-icons icon-align'>visibility</i> Buka Profile</button></a>";
        return $ret;
      })->make(true);
    }

    public function seleksi(Request $r)
    {
      $data = array();
      $data["username"] = \Session::get("username");
      $thn = Setting::where("name","tahun_ajaran")->first()->nilai;
      $data["kuota"] = Setting::where("name","kuota")->first()->nilai - Terpilih::join("user","user.id","terpilih.id")->where("tahun_ajaran",$thn)->count();

      return view("dashboard.content.listsiswa",$data);
    }

    public function seleksiPrestasi(Request $r)
    {
      $data = array();
      $data["username"] = \Session::get("username");
      $thn = Setting::where("name","tahun_ajaran")->first()->nilai;
      $data["kuota"] = Setting::where("name","kuota")->first()->nilai - Terpilih::join("user","user.id","terpilih.id")->where("tahun_ajaran",$thn)->count();

      return view("dashboard.content.listsiswaPrestasi",$data);
    }

    public function seleksiPilih($id){
      $thn = Setting::where("name","tahun_ajaran")->first()->nilai;
      $kuota = Setting::where("name","kuota")->first()->nilai - Terpilih::join("user","user.id","terpilih.id")->where("tahun_ajaran",$thn)->count();

      if($kuota <= 0){
        return \Redirect::to(url("/dashboard/seleksi"))->with(["error" => "Sudah Melebihi kuota"]);
      }
      $ter = new Terpilih;
      $ter->id = $id;
      $ter->status = "Nilai";

      try{
        $ter->save();
        return \Redirect::to(url("/dashboard/seleksi"))->with(["success" => "Berhasil Dipilih"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/seleksi"))->with(["error" => "Database Error"]);
      }
    }

    public function seleksiPilihPost(Request $r){
      $rules = array(
          'active' => 'required'
      );


      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/seleksi"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $list = array_map(function($a){
        return ["id"=>$a,"status"=>"Nilai"];
      },$r->input("active"));

      $thn = Setting::where("name","tahun_ajaran")->first()->nilai;
      $kuota = Setting::where("name","kuota")->first()->nilai - Terpilih::join("user","user.id","terpilih.id")->where("tahun_ajaran",$thn)->count();

      if($kuota < count($list)){
        return \Redirect::to(url("/dashboard/seleksi"))->with(["error" => "Sudah Melebihi kuota"]);
      }

      try{
        Terpilih::insert($list);
        return \Redirect::to(url("/dashboard/seleksi"))->with(["success" => "Berhasil Dipilih"]);
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/seleksi"))->with(["error" => "Terjadi Kesalahan"]);
      }

    }

    function hasilNilai(Request $r){
        //\DB::enableQueryLog();
        /*$users = User::select("user.id","detail_siswa.nama","detail_siswa.asal_sekolah", \DB::raw("ROUND(SUM(nilai_ujian.nilai * ujian.persentase/100)) as total"))
        ->leftJoin("detail_siswa", "user.id", "=", "detail_siswa.id")
        ->leftJoin("nilai_ujian", "user.id", "=", "nilai_ujian.id_siswa")
        ->leftJoin("ujian", "ujian.id_ujian", "=", "nilai_ujian.id_ujian")
        ->where("user.id_tipe","=",3)
        ->whereNotNUll("detail_siswa.nama")
        ->groupBy('user.id')
        ->orderBy('total', 'desc')
        ->get();*/
        $data = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];
        $users = \DB::select("SELECT a.* FROM (SELECT @cur:= @cur+1 as Rank ,p.* FROM (Select @cur:=0) q,(SELECT user.id,detail_siswa.nama,detail_siswa.asal_sekolah, ROUND(SUM(nilai_ujian.nilai*ujian.persentase/100)) as total from user LEFT JOIN detail_siswa ON user.id = detail_siswa.id LEFT JOIN nilai_ujian ON user.id = nilai_ujian.id_siswa LEFT JOIN ujian ON nilai_ujian.id_ujian = ujian.id_ujian WHERE user.id_tipe = 3 AND detail_siswa.nama is not null AND user.tahun_ajaran = $data GROUP BY user.id HAVING total is not null order by total DESC) p) a LEFT JOIN terpilih on terpilih.id = a.id WHERE terpilih.status is null");
        $users = Collection::make($users);

        //dd(\DB::getQueryLog());
        //dd($users);
        return Datatables::of($users)->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/seleksi/pilih')."/".$users->id."'><button class='edit' type='button'><i class='material-icons icon-align'>send</i> Pilih</button></a>";
          return $ret;
        })->addColumn('#', function($users){
          $ret = " <input type='checkbox' name='active[]' id='a".$users->id."' value='".$users->id."' /> <label for='a".$users->id."'> </label>";
          return $ret;
        },0)->make();
    }

    function hasilPrestasi(Request $r){
        $data = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];
        $users = \DB::select("SELECT a.* FROM (SELECT @cur:= @cur+1 as Rank ,p.* FROM (Select @cur:=0) q,(SELECT user.id,detail_siswa.nama,detail_siswa.asal_sekolah, ROUND(SUM(prestasi.nilai) / (SELECT COUNT(*) FROM prestasi where id = user.id)) as total from user LEFT JOIN detail_siswa ON user.id = detail_siswa.id LEFT JOIN prestasi ON user.id = prestasi.id  WHERE user.id_tipe = 3 AND detail_siswa.nama is not null AND user.tahun_ajaran = $data GROUP BY user.id HAVING total is not null order by total DESC) p) a LEFT JOIN terpilih on terpilih.id = a.id WHERE terpilih.status is null");
        $users = Collection::make($users);

        return Datatables::of($users)->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/seleksiPrestasi/pilih')."/".$users->id."'><button class='edit' type='button'><i class='material-icons icon-align'>send</i> Pilih</button></a>";
          return $ret;
        })->addColumn('#', function($users){
          $ret = " <input type='checkbox' name='active[]' id='a".$users->id."' value='".$users->id."' /> <label for='a".$users->id."'> </label>";
          return $ret;
        },0)->make();
    }

    public function seleksiPilihPrestasi($id){
      $kuota = Setting::where("name","kuota")->first()->nilai - Terpilih::all()->count();

      if($kuota <= 0){
        return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["error" => "Sudah Melebihi kuota"]);
      }

      $ter = new Terpilih;
      $ter->id = $id;
      $ter->status = "Prestasi";

      try{
        $ter->save();
        return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["success" => "Berhasil Dipilih"]);
      }
      catch(\Exception $e){
        //$msg = $e->getMessage();
        return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["error" => "Database Error"]);
      }
    }

    public function seleksiPilihPrestasiPost(Request $r){
      $rules = array(
          'active' => 'required'
      );


      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $list = array_map(function($a){
        return ["id"=>$a,"status"=>"Prestasi"];
      },$r->input("active"));

      $kuota = Setting::where("name","kuota")->first()->nilai - Terpilih::all()->count();

      if($kuota < count($list)){
        return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["error" => "Sudah Melebihi kuota"]);
      }

      try{
        Terpilih::insert($list);
        return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["success" => "Berhasil Dipilih"]);
      }
      catch(\Exception $e){
        return \Redirect::to(url("/dashboard/seleksiPrestasi"))->with(["error" => "Terjadi Kesalahan"]);
      }
    }

    public function terpilih(Request $r)
    {
      $data = array();
      $data["username"] = \Session::get("username");
      $thn = Setting::where("name","tahun_ajaran")->first()->nilai;
      $data["kuota"] = Setting::where("name","kuota")->first()->nilai - Terpilih::join("user","user.id","terpilih.id")->where("tahun_ajaran",$thn)->count();

      return view("dashboard.content.terpilih",$data);
    }

    function hasilTerpilih(Request $r){
        //\DB::enableQueryLog();
        $users = User::select("user.id","detail_siswa.nama","detail_siswa.asal_sekolah", "terpilih.status")
        ->join("detail_siswa", "user.id", "=", "detail_siswa.id")
        ->join("terpilih", "user.id", "=", "terpilih.id")
        ->where("user.id_tipe","=",3)
        ->where("user.tahun_ajaran",Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"])
        ->get();

        //dd(\DB::getQueryLog());
        //dd($users);
        return Datatables::of($users)->addColumn('action', function($users){
          $ret = "";
          $ret .= " <a href='".url('/dashboard/terpilih/unpilih')."/".$users->id."'><button class='edit' type='button'><i class='material-icons icon-align'>clear</i> Hapus</button></a>";
          return $ret;
        })->addColumn('#', function($users){
          $ret = " <input type='checkbox' name='active[]' id='a".$users->id."' value='".$users->id."' /> <label for='a".$users->id."'> </label>";
          return $ret;
        },0)->make();
    }

    public function terpilihUn($id)
    {
      $t = Terpilih::find($id);
      if($t->delete()){
        return \Redirect::to(url("/dashboard/terpilih"))->with(["success" => "Bberhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/terpilih"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

    public function terpilihPost(Request $r){
      $rules = array(
          'active' => 'required'
      );


      $validator = \Validator::make($r->all(), $rules);

      if($validator->fails()){
          return \Redirect::to(url("/dashboard/terpilih"))->with(["error" => implode("<br>",$validator->errors()->all())]);
      }

      $list = $r->input("active");

      if(Terpilih::whereIn("id",$list)->delete()){
        return \Redirect::to(url("/dashboard/terpilih"))->with(["success" => "Bberhasil dihapus"]);
      }
      else{
        return \Redirect::to(url("/dashboard/terpilih"))->with(["error" => "Terjadi kesalahan"]);
      }
    }

}
