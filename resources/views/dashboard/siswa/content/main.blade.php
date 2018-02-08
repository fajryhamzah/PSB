@extends("dashboard.siswa.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">// Dashboard </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
      <div class="col s12">

        @if(isset($buka))
          @if(isset($terpilih))
            <div class="card-panel white-text green darken-1" style="text-align:center">
              <p>Peserta Dengan Nomor Pendaftaran:</p>
              <h5>{{$id}}</h5>
              <p>Dinyatakan diterima berdasarkan hasil {{$terpilih->status}}</p>
            </div>
          @else
            <div class="card-panel white-text red darken-1" style="text-align:center">
              <p>Peserta Dengan Nomor Pendaftaran:</p>
              <h5>{{$id}}</h5>
              <p>Dinyatakan gagal</p>
            </div>
          @endif
        @else
          <div class="card-panel white-text blue darken-1"><h5>No pendaftaran anda : {{$id}}</h5></div>
        @endif
        <div class="col l3 s6">
        @if(!isset($nama->nama))
          <div class="small-box bg-red">
            <div class="inner">
              <p>Anda belum mengisi nama lengkap</p>
            </div>
          </div>
        @endif
        </div>
        <div class="col l3 s6">
        @if(!isset($persyaratan->foto))
        <div class="small-box bg-red">
          <div class="inner">
            <p>Anda belum melengkapi foto</p>
          </div>
        </div>
        @endif
        </div>
        <div class="col l3 s6">
        @if(!isset($persyaratan->kartu_keluarga))
        <div class="small-box bg-red">
          <div class="inner">
            <p>Anda belum melengkapi kartu keluarga</p>
          </div>
        </div>
        @endif
        </div>
        <div class="col l3 s6">
        @if(!isset($persyaratan->skhun))
        <div class="small-box bg-red">
          <div class="inner">
            <p>Anda belum melengkapi SKHUN</p>
          </div>
        </div>
        @endif
        </div>
        <!--

        <div class="small-box bg-aqua">
          <div class="inner">
            <h3>{{$jumlah_siswa}</h3>
            <p>Total Pendaftar</p>
          </div>
          <a href="#" class="small-box-footer" class="animsition-link">More info</a>
        </div>
        </div>
        <div class="col l3 s6">

          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$not_active}</h3>
              <p>Menunggu Aktivasi</p>
            </div>
            <a href="#" class="small-box-footer" class="animsition-link">More info</a>
          </div>
          </div>
          <div class="col l3 s6">

            <div class="small-box bg-yellow">
              <div class="inner">
                <h3></h3>
                <p>Pendaftar Hari Ini</p>
              </div>
              <a href="#" class="small-box-footer" class="animsition-link">More info</a>
            </div>
            </div>
            <div class="col l3 s6">

              <div class="small-box bg-red">
                <div class="inner">
                  <h3>{{$penila</h3>
                  <p>Total Penilai</p>
                </div>
                <a href="#" class="small-box-footer" class="animsition-link">More info</a>
              </div>
            </div>
            <div class="container">
              <div class="quick-links center-align">
                <h3>Quick Links</h3>
                <div class="row">
                  <div class="col l3 s12 tooltipped" data-position="top" data-delay="50" data-tooltip="Mod Handbook"><a class="waves-effect waves-light btn-large" href="#">Mod Handbook</a></div>
                  <div class="col l3 s12 tooltipped" data-position="top" data-delay="50" data-tooltip="Staff Applications"><a class="waves-effect waves-light btn-large" href="#">Staff Applications</a></div>
                  <div class="col l3 s12 tooltipped" data-position="top" data-delay="50" data-tooltip="Name Guidelines"><a class="waves-effect waves-light btn-large" href="#">User Guidelines</a></div>
                  <div class="col l3 s12 tooltipped" data-position="top" data-delay="50" data-tooltip="Issue Tracker"><a class="waves-effect waves-light btn-large" href="#">Issue Tracker</a></div>
                  <div class="col l4 offset-l4 s12 tooltipped" data-position="top" data-delay="50" data-tooltip="OTRS Support Site"><a class="waves-effect waves-light btn-large" href="#">Support Site</a></div>
                </div>
              </div>

              <h3 class="center-align">Current Staff Members</h3>
              <div class="custom-responsive">
                <table class="striped hover centered">
                  <thead><tr>
                    <th>Username</th>
                    <th>Access Level</th>
                    <th>Last Site Login</th>
                    <th>TFA Active?</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>MichaelGScott</td>
                    <td>Administrator</td>
                    <td>2017-03-31</td>
                    <td><i class="text-green material-icons">check</i></td>
                  </tr>
                  <tr>
                    <td>JimHalpert</td>
                    <td>Sales</td>
                    <td>2017-03-31</td>
                    <td><i class="text-green material-icons">check</i></td>
                  </tr>
                  <tr>
                    <td>KevinMalone</td>
                    <td>Accounting</td>
                    <td>2017-03-31</td>
                    <td><i class="text-red material-icons">close</i></td>
                  </tr>
                  <tr>
                    <td>PamBeesly</td>
                    <td>Reception</td>
                    <td>2017-03-31</td>
                    <td><i class="text-green material-icons">check</i></td>
                  </tr>
                </tbody>
              </table>
            </div>-->
          </div>
        </div>
  </section>
  </main>
@stop
