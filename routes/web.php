<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', "Daftar@indexDaftar")->middleware("beforelogin");

Route::post('/daftar','Daftar@index');
Route::post('/auth','Daftar@login');

Route::group(['middleware' => 'afterlogin'], function () {
    Route::get('/dashboard','Dashboard@index');
    Route::get('/dashboard/users/serverSide',"Dashboard@data");
    Route::get('/dashboard/logout',"Dashboard@logout");
    Route::get('/dashboard/setting',"Dashboard@setting");
    Route::post('/dashboard/setting',"Dashboard@settingSave");
    Route::get('/dashboard/whoisthis/{id}',"Dashboard@whoisthis");
    Route::get('/dashboard/whoisthis/{id}/{tipe}',"Dashboard@whoisthis");
    Route::get('/dashboard/whoisthis/{id}/{tipe}/{id_ujian}',"Dashboard@whoisthis");

    //SISWA
    Route::group(['middleware' => 'siswa'], function () {
        Route::get('/dashboard/data_diri', 'Siswa@dataDiri');
        Route::post('/dashboard/data_diri', 'Siswa@saveDataDiri');
        Route::get('/dashboard/persyaratan', 'Siswa@persyaratan');
        Route::post('/dashboard/persyaratan', 'Siswa@persyaratanSave');
        Route::get('/dashboard/prestasi', 'Siswa@prestasi');
        Route::get('/dashboard/prestasi/serverSide',"Siswa@prestasiServer");
        Route::get('/dashboard/prestasi/delete/{id}', 'Siswa@prestasiDelete');
        Route::get('/dashboard/prestasi/add', 'Siswa@addPrestasi');
        Route::post('/dashboard/prestasi/add', 'Siswa@addPrestasiSave');
        Route::get('/dashboard/prestasi/edit/{id}', 'Siswa@editPrestasi');
        Route::post('/dashboard/prestasi/edit/', 'Siswa@editPrestasiSave');
        Route::post('/dashboard/prestasi/edit/{id}', 'Siswa@editPrestasiSave');

    });

    //PENILAI
    Route::group(['middleware' => 'penilai'], function () {
        Route::get('/dashboard/list_nilai', 'Dashboard@listNilai');
        Route::get('/dashboard/list_nilai/serverSide','Dashboard@datalistnilai');
        Route::get('/dashboard/list_pendaftar/serverSide','Dashboard@datalistsiswa');
        Route::get('/dashboard/list_nilai/add', 'Penilai@addList');
        Route::post('/dashboard/list_nilai/add','Penilai@addListSave');
        Route::get('/dashboard/list_nilai/delete/{id}', 'Penilai@deleteList');
        Route::get('/dashboard/list_nilai/edit/{id}', 'Penilai@editList');
        Route::post('/dashboard/list_nilai/edit', 'Penilai@editListSave');
        Route::post('/dashboard/list_nilai/edit/{id}', 'Penilai@editListSave');
        Route::get('/dashboard/list_pendaftar', 'Penilai@listSiswa');
        Route::get('/dashboard/list_prestasi', 'Penilai@listPrestasi');
        Route::get('/dashboard/list_pendaftar/check/{id}', 'Penilai@siswaProf');
        Route::get('/dashboard/prestasi/serverSide/{id}',"Penilai@prestasiServer");
        Route::get('/dashboard/prestasi/nilai/{id}', 'Penilai@nilaiPrestasi');
        Route::get('/dashboard/prestasi/nilai/edit/{id}', 'Penilai@nilaiPrestasiEdit');
        Route::get('/dashboard/prestasi/nilai/delete/{id}', 'Penilai@hapusPrestasiNilai');
        Route::get('/dashboard/prestasi/sudahdinilai', 'Penilai@listPrestasiSudahDiNilai');
        Route::get('/dashboard/prestasi/belumdinilai', 'Penilai@listPrestasiSemua');
        Route::post('/dashboard/prestasi/nilai/{id}', 'Penilai@nilaiPrestasiSave');
        Route::post('/dashboard/prestasi/nilai', 'Penilai@nilaiPrestasiSave');
        Route::post('/dashboard/prestasi/nilai/edit/{id}', 'Penilai@nilaiPrestasiSave');
        Route::post('/dashboard/prestasi/nilai/edit', 'Penilai@nilaiPrestasiSave');
    });

    //OPERATOR
    Route::group(['middleware' => 'operator'], function () {
      //penilai
      Route::get('/dashboard/penilai', 'Dashboard@penilai');
      Route::get('/dashboard/penilai/serverSide',"Dashboard@datapenilai");
      Route::get('/dashboard/penilai/delete/{id}', 'Penilai@delete');
      Route::get('/dashboard/penilai/edit/{id}', 'Penilai@edit');
      Route::get('/dashboard/penilai/add', function(){
        $data = array();
        $data["username"] = \Session::get("username");
        return view('dashboard.content.addPenilai',$data);
      });
      Route::post('/dashboard/penilai/add','Penilai@add');
      Route::post('/dashboard/penilai/edit/{id}','penilai@editSave');
      Route::post('/dashboard/penilai/edit','penilai@editSave');

      //siswa
      //Route::get('/dashboard/prestasi/serverSide/{id}',"Penilai@prestasiServer");
      Route::get('/dashboard/seleksi', 'Dashboard@seleksi');
      Route::get('/dashboard/seleksi/pilih/{id}', 'Dashboard@seleksiPilih');
      Route::post('/dashboard/seleksi', 'Dashboard@seleksiPilihPost');
      Route::get('/dashboard/seleksiPrestasi', 'Dashboard@seleksiPrestasi');
      Route::get('/dashboard/seleksiPrestasi/pilih/{id}', 'Dashboard@seleksiPilihPrestasi');
      Route::post('/dashboard/seleksiPrestasi', 'Dashboard@seleksiPilihPrestasiPost');
      Route::get('/dashboard/terpilih', 'Dashboard@terpilih');
      Route::get('/dashboard/list_hasil/serverSide','Dashboard@hasilNilai');
      Route::get('/dashboard/list_hasil_prestasi/serverSide','Dashboard@hasilPrestasi');
      Route::get('/dashboard/list_terpilih/serverSide','Dashboard@hasilTerpilih');
      Route::get('/dashboard/terpilih/unpilih/{id}', 'Dashboard@terpilihUn');
      Route::post('/dashboard/terpilih', 'Dashboard@terpilihPost');
      Route::get('/dashboard/casis', 'Dashboard@casis');
      Route::get('/dashboard/siswa', 'Dashboard@casis');
      Route::get('/dashboard/siswa/activate/{id}', 'Siswa@activate');
      Route::get('/dashboard/siswa/deactivate/{id}', 'Siswa@deactivate');
      Route::get('/dashboard/siswa/delete/{id}', 'Siswa@delete');
      Route::get('/dashboard/siswa/edit/{id}', 'Siswa@edit');
      Route::get('/dashboard/siswa/add', function(){
        $data = array();
        $data["username"] = \Session::get("username");
        return view('dashboard.content.addSiswa',$data);
      });
      Route::post('/dashboard/siswa/add','Siswa@add');
      Route::post('/dashboard/siswa/edit/{id}','Siswa@editSave');
      Route::post('/dashboard/siswa/edit','Siswa@editSave');


      //admin
      Route::get('/dashboard/pekerjaan', 'Dashboard@pekerjaan');
      Route::get('/dashboard/pekerjaan/serverSide',"Dashboard@datapekerjaan");
      Route::get('/dashboard/pekerjaan/add', function(){
        $data = array();
        $data["username"] = \Session::get("username");
        return view('dashboard.content.addPekerjaan',$data);
      });

      Route::get('/dashboard/ujian',"Dashboard@ujian");
      Route::get('/dashboard/ujian/serverSide',"Dashboard@dataujian");
      Route::get('/dashboard/ujian/add','UjianCont@addView' );


      Route::post('/dashboard/ujian/add','UjianCont@add');
      Route::get('/dashboard/ujian/delete/{id}', 'UjianCont@delete');
      Route::get('/dashboard/ujian/edit/{id}', 'UjianCont@edit');
      Route::post('/dashboard/ujian/edit/{id}','UjianCont@editSave');
      Route::post('/dashboard/ujian/edit','UjianCont@editSave');

      Route::post('/dashboard/pekerjaan/add','PekerjaanCont@add');
      Route::get('/dashboard/pekerjaan/delete/{id}', 'PekerjaanCont@delete');
      Route::get('/dashboard/pekerjaan/edit/{id}', 'PekerjaanCont@edit');
      Route::post('/dashboard/pekerjaan/edit/{id}','pekerjaanCont@editSave');
      Route::post('/dashboard/pekerjaan/edit','pekerjaanCont@editSave');

      Route::get('/laporan/pendaftar', 'Laporan@pendaftar');
      Route::get('/laporan/pendaftar/{thn}', 'Laporan@pendaftarByGender');
      Route::get('/laporan/download/pendaftar/tahun/{thn}', 'Laporan@laporanPendaftar');

      Route::get('/laporan/diterima', 'Laporan@diterima');
      Route::get('/laporan/diterima/{thn}', 'Laporan@diterimaPerStatus');
      Route::get('/laporan/diterima/gender/{thn}', 'Laporan@diterimaPerGender');
      Route::get('/laporan/download/diterima/tahun/{thn}', 'Laporan@laporanDiterima');
      Route::get('/laporan/download/diterima/nilai/tahun/{thn}', 'Laporan@diterimaNilai');
      Route::get('/laporan/download/diterima/prestasi/tahun/{thn}', 'Laporan@diterimaPrestasi');
      Route::get('/laporan/download/diterima/semua/nilai/tahun/{thn}', 'Laporan@laporanNilai');
      Route::get('/laporan/download/diterima/semua/prestasi/tahun/{thn}', 'Laporan@laporanPrestasi');

      Route::get('/backup', 'Laporan@backup');
    });

});
