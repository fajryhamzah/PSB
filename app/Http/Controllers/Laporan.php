<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Setting;

use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Collection;

class Laporan extends Controller
{
    private $parser = array();
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

     function pendaftar(){
       $data['username'] = \Session::get("username");
       $ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];
       $data['thn'] = array();
       //\DB::enableQueryLog();
       $data['pendaftar'] = User::select("tahun_ajaran",\DB::raw("COUNT(id) as jumlah"))->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran","<=",$ajaran)->groupBy("tahun_ajaran")->get()->toArray();
       //dd(\DB::getQueryLog());
       //dd($data);
       $data['pertahun'] = User::select("tahun_ajaran")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran","<=",$ajaran)->groupBy("tahun_ajaran")->get()->toArray();
       $new = array();
       for($i = $ajaran-4;$i<=$ajaran;$i++){
         $data['thn'][] = $i;
         $new[strval($i)] = 0;
       }


        foreach($data['pendaftar'] as $a){
          $new[strval($a['tahun_ajaran'])] = $a['jumlah'];
        }

        $data['pendaftar'] = $new;


      	//$pdf = PDF::loadView('dashboard.content.laporanPendaftarPDF');
      	//return $pdf->output();
      	//return $pdf->stream('document.pdf');
       return view("dashboard.content.laporanPendaftar",$data);
     }

     function pendaftarByGender($thn){
       $data = User::join("detail_siswa","detail_siswa.id","user.id")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran",$thn)->get();
       //dd($data);
       $laki = $data->where("jenis_kelamin","L")->count();
       $woman = $data->where("jenis_kelamin","P")->count();
       $dunno = $data->whereNotIn("jenis_kelamin",["L","P"])->count();


       return implode(",",array($laki,$woman,$dunno));
     }

     function laporanPendaftar($thn){
       $data['dt'] = User::select("user.id","nama","jenis_kelamin","asal_sekolah")->join("detail_siswa","detail_siswa.id","user.id")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran",$thn)->get();
       //dd($data);
       $data['thn'] = $thn;
       $data['jumlah'] = $data['dt']->count();
       $data['laki'] = $data['dt']->where("jenis_kelamin","L")->count();
       $data['woman'] = $data['dt']->where("jenis_kelamin","P")->count();
       $data['dunno'] = $data['dt']->whereNotIn("jenis_kelamin",["L","P"])->count();


       $pdf = PDF::loadView('dashboard.content.laporanPendaftarPDF',$data);
       return $pdf->stream('Laporan Pendaftar Tahun Ajaran '.$thn.'.pdf');
     }

     function diterima(){
       $data['username'] = \Session::get("username");
       $ajaran = Setting::where("name","tahun_ajaran")->first()->toArray()["nilai"];
       $data['thn'] = array();
       //\DB::enableQueryLog();
       $data['pendaftar'] = User::select("tahun_ajaran",\DB::raw("COUNT(user.id) as jumlah"))->join("terpilih","terpilih.id","user.id")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran","<=",$ajaran)->groupBy("tahun_ajaran")->get()->toArray();
       //dd(\DB::getQueryLog());
       //dd($data);
       $data['pertahun'] = User::select("tahun_ajaran")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran","<=",$ajaran)->groupBy("tahun_ajaran")->get()->toArray();
       $new = array();
       for($i = $ajaran-4;$i<=$ajaran;$i++){
         $data['thn'][] = $i;
         $new[strval($i)] = 0;
       }

        foreach($data['pendaftar'] as $a){
          $new[strval($a['tahun_ajaran'])] = $a['jumlah'];
        }

        $data['pendaftar'] = $new;

       return view("dashboard.content.laporanDiterima",$data);
     }


     function diterimaPerStatus($thn){
       $data = User::join("terpilih","terpilih.id","user.id")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran",$thn)->get();
       //dd($data);
       $nilai = $data->where("status","Nilai")->count();
       $prestasi = $data->where("status","Prestasi")->count();



       return implode(",",array($nilai,$prestasi));
     }

     function diterimaPerGender($thn){
       $data = User::join("detail_siswa","detail_siswa.id","user.id")->join("terpilih","terpilih.id","user.id")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran",$thn)->get();
       //dd($data);
       $laki = $data->where("jenis_kelamin","L")->count();
       $woman = $data->where("jenis_kelamin","P")->count();
       $dunno = $data->whereNotIn("jenis_kelamin",["L","P"])->count();


       return implode(",",array($laki,$woman,$dunno));
     }

     function laporanDiterima($thn){
       $data['dt'] = User::select("user.id","nama","jenis_kelamin","asal_sekolah","status")->join("detail_siswa","detail_siswa.id","user.id")->join("terpilih","terpilih.id","user.id")->where("id_tipe",3)->where("aktif",1)->where("tahun_ajaran",$thn)->orderBy("status")->get();
       //dd($data);
       $data['thn'] = $thn;
       $data['kuota'] = Setting::where("name","kuota")->first()->toArray()["nilai"];
       $data['jumlah'] = $data['dt']->count();
       $data['laki'] = $data['dt']->where("jenis_kelamin","L")->count();
       $data['woman'] = $data['dt']->where("jenis_kelamin","P")->count();
       $data['dunno'] = $data['dt']->whereNotIn("jenis_kelamin",["L","P"])->count();


       $pdf = PDF::loadView('dashboard.content.laporanDiterimaPDF',$data);
       return $pdf->stream('Laporan Pendaftar Diterima Tahun Ajaran '.$thn.'.pdf');
       //return view('dashboard.content.laporanDiterimaPDF',$data);
     }

     function diterimaNilai($thn){
       $users = \DB::select("SELECT a.* FROM (SELECT @cur:= @cur+1 as Rank ,p.* FROM (Select @cur:=0) q,(SELECT user.id,detail_siswa.jenis_kelamin,detail_siswa.nama,detail_siswa.asal_sekolah, ROUND(SUM(nilai_ujian.nilai*ujian.persentase/100)) as total from user LEFT JOIN detail_siswa ON user.id = detail_siswa.id LEFT JOIN nilai_ujian ON user.id = nilai_ujian.id_siswa LEFT JOIN ujian ON nilai_ujian.id_ujian = ujian.id_ujian WHERE user.id_tipe = 3 AND detail_siswa.nama is not null AND user.tahun_ajaran = $thn GROUP BY user.id HAVING total is not null order by total DESC) p) a LEFT JOIN terpilih on terpilih.id = a.id WHERE terpilih.status LIKE '%nilai%' order by Rank");
       $users = Collection::make($users);

       $data['dt'] = $users;
       //dd($data);
       $data['thn'] = $thn;
       $data['kuota'] = Setting::where("name","kuota")->first()->toArray()["nilai"];
       $data['jumlah'] = $data['dt']->count();
       $data['laki'] = $data['dt']->where("jenis_kelamin","L")->count();
       $data['woman'] = $data['dt']->where("jenis_kelamin","P")->count();
       $data['dunno'] = $data['dt']->whereNotIn("jenis_kelamin",["L","P"])->count();


       $pdf = PDF::loadView('dashboard.content.laporanDiterimaNilaiPDF',$data);
       return $pdf->stream('Laporan Pendaftar Diterima Berdsarakan Nilai Tahun Ajaran '.$thn.'.pdf');
       //return view('dashboard.content.laporanDiterimaNilaiPDF',$data);
     }

     function diterimaPrestasi($thn){
       $users = \DB::select("SELECT a.* FROM (SELECT @cur:= @cur+1 as Rank ,p.* FROM (Select @cur:=0) q,(SELECT user.id,detail_siswa.nama,detail_siswa.jenis_kelamin,detail_siswa.asal_sekolah, ROUND(SUM(prestasi.nilai) / (SELECT COUNT(*) FROM prestasi where id = user.id)) as total from user LEFT JOIN detail_siswa ON user.id = detail_siswa.id LEFT JOIN prestasi ON user.id = prestasi.id  WHERE user.id_tipe = 3 AND detail_siswa.nama is not null AND user.tahun_ajaran = $thn GROUP BY user.id HAVING total is not null order by total DESC) p) a LEFT JOIN terpilih on terpilih.id = a.id WHERE terpilih.status LIKE '%prestasi%' order by Rank");
       $users = Collection::make($users);

       $data['dt'] = $users;
       //dd($data);
       $data['thn'] = $thn;
       $data['kuota'] = Setting::where("name","kuota")->first()->toArray()["nilai"];
       $data['jumlah'] = $data['dt']->count();
       $data['laki'] = $data['dt']->where("jenis_kelamin","L")->count();
       $data['woman'] = $data['dt']->where("jenis_kelamin","P")->count();
       $data['dunno'] = $data['dt']->whereNotIn("jenis_kelamin",["L","P"])->count();


       $pdf = PDF::loadView('dashboard.content.laporanDiterimaPrestasiPDF',$data);
       return $pdf->stream('Laporan Pendaftar Diterima Berdasarkan Nilai Prestasi Tahun Ajaran '.$thn.'.pdf');
       //return view('dashboard.content.laporanDiterimaPrestasiPDF',$data);
     }

     function laporanNilai($thn){
       $users = \DB::select("SELECT a.* FROM (SELECT @cur:= @cur+1 as Rank ,p.* FROM (Select @cur:=0) q,(SELECT user.id,detail_siswa.jenis_kelamin,detail_siswa.nama,detail_siswa.asal_sekolah, ROUND(SUM(nilai_ujian.nilai*ujian.persentase/100)) as total from user LEFT JOIN detail_siswa ON user.id = detail_siswa.id LEFT JOIN nilai_ujian ON user.id = nilai_ujian.id_siswa LEFT JOIN ujian ON nilai_ujian.id_ujian = ujian.id_ujian WHERE user.id_tipe = 3 AND user.tahun_ajaran = $thn GROUP BY user.id order by total DESC) p) a order by Rank");
       $users = Collection::make($users);

       $data['dt'] = $users;
       //dd($data);
       $data['thn'] = $thn;
       $data['kuota'] = Setting::where("name","kuota")->first()->toArray()["nilai"];
       $data['laki'] = $data['dt']->where("jenis_kelamin","L")->count();
       $data['woman'] = $data['dt']->where("jenis_kelamin","P")->count();
       $data['dunno'] = $data['dt']->whereNotIn("jenis_kelamin",["L","P"])->count();


       $pdf = PDF::loadView('dashboard.content.laporanNilaiPDF',$data);
       return $pdf->stream('Laporan Nilai Pendaftar Tahun Ajaran '.$thn.'.pdf');
       //return view('dashboard.content.laporanNilaiPDF',$data);
     }

     function laporanPrestasi($thn){
       $users = \DB::select("SELECT a.* FROM (SELECT @cur:= @cur+1 as Rank ,p.* FROM (Select @cur:=0) q,(SELECT user.id,detail_siswa.nama,detail_siswa.jenis_kelamin,detail_siswa.asal_sekolah, ROUND(SUM(prestasi.nilai) / (SELECT COUNT(*) FROM prestasi where id = user.id)) as total from user LEFT JOIN detail_siswa ON user.id = detail_siswa.id LEFT JOIN prestasi ON user.id = prestasi.id  WHERE user.id_tipe = 3 AND user.tahun_ajaran = $thn GROUP BY user.id order by total DESC) p) a order by Rank");
       $users = Collection::make($users);

       $data['dt'] = $users;
       //dd($data);
       $data['thn'] = $thn;
       $data['kuota'] = Setting::where("name","kuota")->first()->toArray()["nilai"];
       $data['laki'] = $data['dt']->where("jenis_kelamin","L")->count();
       $data['woman'] = $data['dt']->where("jenis_kelamin","P")->count();
       $data['dunno'] = $data['dt']->whereNotIn("jenis_kelamin",["L","P"])->count();


       $pdf = PDF::loadView('dashboard.content.laporanPrestasiPDF',$data);
       return $pdf->stream('Laporan Prestasi Pendaftar Tahun Ajaran '.$thn.'.pdf');
       //return view('dashboard.content.laporanPrestasiPDF',$data);
     }

     function backup(){
       \Artisan::call("backup:clean");
       \Artisan::call("backup:run",["--only-db" => true]);
       $files = \File::allFiles(storage_path("app/penerimaan-siswa"));
       return response()->download($files[count($files)-1]);
     }



}
