@extends("dashboard.penilai.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Profile Siswa </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
      <div class="input-field col s5 offset-s5">
        <img src="{{asset('img/siswa')}}/{{$foto}}" alt="" class="circle" style="max-width:150px;min-width:150px;min-height:150px;max-height:150px;Display:block">
      </div>
      <div class="col s12">
        <ul class="tabs">
          <li class="tab col s3"><a href="#data">Data Diri</a></li>
          <li class="tab col s3"><a class="active" href="#prestasi">Prestasi</a></li>
        </ul>

        <div id="data">
          <table class="striped responsive-table">
            <tbody>
              <tr>
                <td>Nama Lengkap</td>
                <td>{{$nama}}</td>
              </tr>
              <tr>
                <td>Jenis Kelamin</td>
                <td>{{ strtolower($jk) == "p" ? "Perempuan": "Laki-laki"}}</td>
              </tr>
              <tr>
                <td>Tanggal Lahir</td>
                <td>{{date("d M Y",strtotime($tgl))}}</td>
              </tr>
              <tr>
                <td>Umur</td>
                <td>{{$umur}}</td>
              </tr>
              <tr>
                <td>Asal Sekolah</td>
                <td>{{$asal_sek}}</td>
              </tr>
              <tr>
                <td>No Telp/HP</td>
                <td>{{$notelp}}</td>
              </tr>
              <tr>
                <td>Alamat</td>
                <td>{{$alamat}}</td>
              </tr>
              <tr>
                <td>Nama Ayah</td>
                <td>{{$nama_ayah}}</td>
              </tr>
              <tr>
                <td>No Telp/HP ayah</td>
                <td>{{$notelpayah}}</td>
              </tr>
              <tr>
                <td>Pekerjaan ayah</td>
                <td>{{$pek_ayah}}</td>
              </tr>
              <tr>
                <td>Alamat ayah</td>
                <td>{{$alamatayah}}</td>
              </tr>
              <tr>
                <td>Nama ibu</td>
                <td>{{$nama_ibu}}</td>
              </tr>
              <tr>
                <td>No Telp/HP ibu</td>
                <td>{{$notelpibu}}</td>
              </tr>
              <tr>
                <td>Pekerjaan ibu</td>
                <td>{{$pek_ibu}}</td>
              </tr>
              <tr>
                <td>Alamat ibu</td>
                <td>{{$alamatibu}}</td>
              </tr>
              <tr>
                <td>Status</td>
                <td>{{ $stat == 0 ? "Kandung": "Wali"}}</td>
              </tr>
            </tbody>
          </table>
      </div>

      <div id="prestasi">
        <div class="col s12">
          <table class="datatable">
            <thead>
              <tr>
                <th>Nama prestasi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
  </main>
@stop

@section("include_js")
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
@stop

@section("js")
  $('.datatable').DataTable({
      dom: 'lBfrtip',
      "bLengthChange": false,
      processing: true,
      serverSide: true,
      order: [ [0, 'desc'] ],
      ajax: '{{ url('/dashboard/prestasi/serverSide/').'/'.$id }}'
  });

@stop

@section("include_css")
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
.aktif{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #26a69a;
}

.aktif:hover{
  background-color: #009688;
}

.edit{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #0288d1;
}

.edit:hover{
  background-color: #0277bd;
}

.nonaktif{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #F44336;
}

.nonaktif:hover{
  background-color: #E53935;
}

.hapus{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #C62828;
}

.hapus:hover{
  background-color: #B71C1C;
}

.icon-align{
  vertical-align: text-bottom;
}
</style>
@stop
