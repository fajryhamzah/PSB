@extends($extend)
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Setting </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
          @if (\Session::has('error'))
            <div class="row" id="error">
              <div class="col s12 m10 l10 offset-m1 offset-l1">
                  <div class="chip red darken-1" style="padding: 10px 10px 10px 10px; width: 100%; height:100%; border-radius:0px;">
                      <i class=" close material-icons right white-text">close</i>
                      <div class="white-text"><b>Error : </b> <p id="err">{!! \Session::get('error') !!}</p></div>
                  </div>
              </div>
            </div>
          @endif
          <form class="col s12" method="post" enctype="multipart/form-data" >
            <span class="subheader">Data diri</span>
            <div class="row">
              <div class="input-field col s5">
                <input id="title" type="text" name="nama" value="{{$username}}" class="validate" disabled>
                <label for="title">Username</label>
              </div>
            </div>
            @if( \Session::get("tipe") == 1)
              <div class="row">
                <div class="input-field col s5">
                  <input id="tgl_mulai" type="text" name="tgl_mulai" data-value="{{$tgl_mulai}}" class="validate datepicker1">
                  <label for="tgl_mulai">Tanggal mulai</label>
                </div>
              </div>
              <span class="subheader">Pendaftaran</span>
              <div class="row">
                <div class="input-field col s5">
                  <input id="tgl_mulai" type="text" name="tgl_mulai" data-value="{{$tgl_mulai}}" class="validate datepicker1">
                  <label for="tgl_mulai">Tanggal mulai</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s5">
                  <input id="tgl_akhir" type="text" name="tgl_akhir" data-value="{{$tgl_akhir}}" class="validate datepicker">
                  <label for="tgl_akhir">Tanggal akhir</label>
                </div>
              </div>

              <span class="subheader">Penerimaan</span>
              <div class="row">
                <div class="input-field col s5">
                  <input id="th" type="number" name="th" value="{{$thn}}" class="validate">
                  <label for="th">Tahun ajaran</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s5">
                  <input id="tgl_akhir1" type="text" name="tgl_buka" data-value="{{$tgl_buka}}" class="validate datepicker2">
                  <label for="tgl_akhir1">Tanggal pembukaan hasil</label>
                </div>
              </div>
              <div class="row">
                <div class="input-field col s5">
                  <input id="pener" type="number" name="kuota" value="{{$kuota}}" class="validate">
                  <label for="pener">Kuota Penerimaan</label>
                </div>
              </div>
            @endif

            <span class="subheader">Ganti Password</span>
            <div class="row">
              <div class="input-field col s5">
                <input id="title1" type="password" name="passbaru" class="validate">
                <label for="title1">Password Baru</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s5">
                <input id="title2" type="password" name="passbarukonf" class="validate">
                <label for="title3">Konfirmasi Password Baru</label>
              </div>
            </div>

            <div class="row">
              <div class="input-field col s5">
                <input id="title3" type="password" name="passlama" class="validate">
                <label for="title3">Password Lama</label>
              </div>
            </div>

            @if(\Session::get("tipe") == 1)
              <span class="subheader">Backup/Restore</span>
              <div class="row">
                <div class="input-field col s6">
                  <a class="waves-effect waves-light btn light-blue" href="{{url("backup")}}"><i class="material-icons left">backup</i> Backup</a>
                  <div class="file-field input-field">
                    <div class="btn deep-orange">
                      <span><i class="material-icons left">update</i>Restore</span>
                      <input type="file" name="restore">
                    </div>
                    <div class="file-path-wrapper">
                      <input class="file-path validate" type="text">
                    </div>
                  </div>
                </div>
              </div>
            @endif

            <div class="input-field col s8">
              <button class="btn waves-effect waves-light" type="submit" name="action">Save
                <i class="material-icons right">archive</i>
              </button>
            </div>

            </div>
          </form>
      </div>
  </section>
  </main>
@stop

@section("js")
@if (isset($succ))
    var $toastContent = $("<span>{{ $succ }}</span>");
    Materialize.toast($toastContent, 3000,"green lighten-2");
@endif
$('.datepicker').pickadate({
   selectMonths: true, // Creates a dropdown to control month
   selectYears: 20, // Creates a dropdown of 15 years to control year,
   today: 'Today',
   clear: 'Clear',
   formatSubmit: 'yyyy/mm/dd',
   hiddenName: true,
   close: 'Ok',
 });

@if( \Session::get("tipe") == 1)
 $('.datepicker1').pickadate({
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 20, // Creates a dropdown of 15 years to control year,
    today: 'Today',
    clear: 'Clear',
    formatSubmit: 'yyyy/mm/dd',
    hiddenName: true,
    max: new Date("{{$tgl_akhir}}"),
    close: 'Ok',
  });

  $('.datepicker2').pickadate({
     selectMonths: true, // Creates a dropdown to control month
     selectYears: 20, // Creates a dropdown of 15 years to control year,
     today: 'Today',
     clear: 'Clear',
     formatSubmit: 'yyyy/mm/dd',
     hiddenName: true,
     min: new Date("{{$tgl_akhir}}"),
     close: 'Ok',
   });
  @endif
@stop
