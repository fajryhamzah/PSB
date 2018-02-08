@extends("dashboard.siswa.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">// Data Diri </h1></div>
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
          <form class="col s12" method="post">
            <span class="subheader">Data Siswa</span>
            <div class="row">
              <div class="input-field col s12">
                <input id="title" type="text" name="nama" value="{{$nama}}" class="validate">
                <label for="title">Nama Lengkap</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select name="jk">
                  <option value="L">Laki-laki</option>
                  <option value="P" {{ strtolower($jk) == "p" ? "selected": ""}}>Perempuan</option>
                </select>
                <label>Jenis Kelamin</label>
              </div>
              <div class="input-field col s6">
                <input class="datepicker" name="tgl_lahir" type="date" data-value="{{$tgl}}" id="tgl">
                <label for="tgl">Tanggal Lahir</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input name="asal_sek" type="text" id="organizer" class="validate" value="{{$asal_sek}}">
                <label for="organizer">Asal Sekolah</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="no" class="materialize-textarea" name="notelp">{{$notelp}}</textarea>
                <label for="no">No Telepon/Hp (pisah dengan enter jika lebih dari satu)</label>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                  <textarea id="description" class="materialize-textarea" name="alamat">{{$alamat}}</textarea>
                  <label for="description">Alamat</label>
                </div>
            </div>

            <span class="subheader">Data Orangtua</span>

            <div class="row">
              <div class="input-field col s12">
                <input id="titl" type="text" name="nama_ayah" class="validate" value="{{$nama_ayah}}">
                <label for="titl">Nama ayah</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="noa" class="materialize-textarea" name="notelpayah">{{$notelpayah}}</textarea>
                <label for="noa">No Telepon/Hp ayah (pisah dengan enter jika lebih dari satu)</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select name="pk_ayah">
                  @foreach($pekerjaan as $key => $val)
                    <option value="{{$val['id_pekerjaan']}}" {{$id_ayah == $val['id_pekerjaan'] ? "selected": ""}}>{{$val['nama_pekerjaan']}}</option>
                  @endforeach
                </select>
                <label>Pekerjaan ayah</label>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                  <textarea id="descriptio" class="materialize-textarea" name="alamatayah">{{$alamatayah}}</textarea>
                  <label for="descriptio">Alamat ayah</label>
                </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select name="stat_ayah">
                  <option value="0" {{$stat_ayah == 0 ? "selected": ""}}>Kandung</option>
                  <option value="1" {{$stat_ayah == 1 ? "selected": ""}}>Wali</option>
                </select>
                <label>Status Ayah</label>
              </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="tit" type="text" name="nama_ibu" class="validate" value="{{$nama_ibu}}">
                <label for="tit">Nama ibu</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <textarea id="noi" class="materialize-textarea" name="notelpibu">{{$notelpibu}}</textarea>
                <label for="noi">No Telepon/Hp ibu (pisah dengan enter jika lebih dari satu)</label>
              </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select name="pk_ibu">
                  @foreach($pekerjaan as $key => $val)
                    <option value="{{$val['id_pekerjaan']}}" {{$id_ibu == $val['id_pekerjaan'] ? "selected": ""}}>{{$val['nama_pekerjaan']}}</option>
                  @endforeach
                </select>
                <label>Pekerjaan ibu</label>
              </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                  <textarea id="descripti" class="materialize-textarea" name="alamatibu">{{$alamatibu}}</textarea>
                  <label for="descripti">Alamat ibu</label>
                </div>
            </div>
            <div class="row">
              <div class="input-field col s6">
                <select name="stat_ibu">
                  <option value="0" {{$stat_ibu == 0 ? "selected": ""}}>Kandung</option>
                  <option value="1" {{$stat_ibu == 1 ? "selected": ""}}>Wali</option>
                </select>
                <label>Status Ibu</label>
              </div>

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
@if (\Session::has('success'))
    var $toastContent = $("<span>{!! \Session::get('success') !!}</span>");
    Materialize.toast($toastContent, 3000,"green lighten-2");
@endif
$('.datepicker').pickadate({
   selectMonths: true, // Creates a dropdown to control month
   selectYears: 20, // Creates a dropdown of 15 years to control year,
   today: 'Today',
   clear: 'Clear',
   formatSubmit: 'yyyy/mm/dd',
   hiddenName: true,
   max: new Date(),
   close: 'Ok',
 });
@stop
