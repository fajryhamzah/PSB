<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Laporan</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
      td{
        padding: 4px;
      }

      thead{
        border: 1px solid #d0d0d0;
      }

      .striped th, .id, .status{
        text-align: center;
      }

      .striped td, .striped th{
        border: 1px solid #d0d0d0;
      }
  </style>
  </head>
<body>
  <div class="container">
    <div class="row">
      <div class="col s12">
        <div>
          <h5 class="center-align">Laporan Data Calon Siswa</h5>
          <h5 class="center-align">Penerimaan Siswa Baru tahun {{$thn}}</h5>
        </div>

        <div class="divider"></div>

        <div style="margin-top:2%;margin-bottom:2%;" class="col s5">
          <table>
            <tbody>
              <tr>
                <td>Kuota Penerimaan</td>
                <td>{{$kuota}}</td>
              </tr>
              <tr>
                <td>Calon siswa laki-laki</td>
                <td>{{$laki}}</td>
              </tr>
              <tr>
                <td>Calon siswa perempuan</td>
                <td>{{$woman}}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <table class="striped">
          <thead>
            <tr>
              <th style="">Rank</th>
              <th style="">No pendaftar</th>
              <th>Nama Lengkap</th>
              <th>Jenis Kelamin</th>
              <th>Sekolah asal</th>
              <th>Nilai</th>
            </tr>
          </thead>
          <tbody>
            @foreach($dt as $a)
              <tr>
                <td class="id">{{ ($a->total !== NULL ? $a->Rank:"-")}}</td>
                <td class="id">{{$a->id}}</td>
                <td>{{ ($a->nama !== NULL ? $a->nama:"Belum diisi")}}</td>
                <td>{{ ($a->jenis_kelamin !== NULL ? $a->jenis_kelamin:"Belum diisi")}}</td>
                <td>{{ ($a->asal_sekolah !== NULL ? $a->asal_sekolah:"Belum diisi")}}</td>
                <td>{{ ($a->total !== NULL ? $a->total:0)}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <!-- So this is basically a hack, until I come up with a better solution. autocomplete is overridden
  in the materialize js file & I don't want that.
  -->
  <!-- Yo dawg, I heard you like hacks. So I hacked your hack. (moved the sidenav js up so it actually works) -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script  src="{{ asset('js/materialize.min.js') }}"></script>
  <script>
    $(document).ready(function(){

    });
  </script>
  </div>

  </body>
  </html>
