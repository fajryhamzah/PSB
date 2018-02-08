@extends("dashboard.siswa.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">// Persyaratan </h1></div>
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
          <form class="col s12" method="post" enctype="multipart/form-data">
            <div class="row">


              <div class="col s12">
                <ul class="tabs">
                  <li class="tab col s3"><a class="active" href="#test1">Foto</a></li>
                  <li class="tab col s3"><a href="#test2">Kartu Keluarga</a></li>
                  <li class="tab col s3"><a  href="#test3">SKHUN</a></li>
                  <li class="tab col s3"><a href="#test4">SKPK (Optional)</a></li>
                </ul>
              </div>

              <div id="test1" class="col s12">
                <div class="input-field col s5 offset-s5">
                  <img src="{{asset('img/siswa')}}/{{$foto}}" alt="" class="circle" style="max-width:150px;min-width:150px;min-height:150px;max-height:150px;Display:block">
                </div>
                <div class="col s12">
                  <div class="file-field input-field">
                     <div class="btn">
                       <span>Upload foto</span>
                       <input type="file" name="foto">
                     </div>
                     <div class="file-path-wrapper">
                       <input class="file-path validate" type="text">
                     </div>
                   </div>
                </div>
              </div>

              <div id="test2" class="col s12">
                <div class="col s12">
                  <div class="card">
                    @if($kk != "")
                    <div class="card-image">
                      <img class="materialboxed" src="{{asset('img/siswa/'.$kk)}}">
                    </div>
                    @endif
                    <div class="card-content">
                      <div class="file-field input-field">
                         <div class="btn">
                           <span>Upload KK</span>
                           <input type="file" name="kk">
                         </div>
                         <div class="file-path-wrapper">
                           <input class="file-path validate" type="text">
                         </div>
                       </div>
                    </div>
                    </div>
                  </div>
                </div>

              <div id="test3" class="col s12">
                <div class="col s12">
                  <div class="card">
                    @if($skhun != "")
                    <div class="card-image">
                      <img class="materialboxed" src="{{asset('img/siswa/'.$skhun)}}">
                    </div>
                    @endif
                    <div class="card-content">
                      <div class="file-field input-field">
                         <div class="btn">
                           <span>Upload SKHUN</span>
                           <input type="file" name="skhun">
                         </div>
                         <div class="file-path-wrapper">
                           <input class="file-path validate" type="text">
                         </div>
                       </div>
                    </div>
                    </div>
                  </div>
                </div>


              <div id="test4" class="col s12">
                <div class="col s12">
                  <div class="card">
                    @if($skpk != "")
                    <div class="card-image">
                      <img class="materialboxed" src="{{asset('img/siswa/'.$skpk)}}">
                    </div>
                    @endif
                    <div class="card-content">
                      <div class="file-field input-field">
                         <div class="btn">
                           <span>Upload SKPK</span>
                           <input type="file" name="skpk">
                         </div>
                         <div class="file-path-wrapper">
                           <input class="file-path validate" type="text">
                         </div>
                       </div>
                    </div>
                    </div>
                  </div>
                </div>

                <div>
                  <h8 class="left-align">File gambar max 2MB</h8>
                </div>

                <div class="input-field col s8 offset-s5">
                  <button class="btn waves-effect waves-light" type="submit" name="action">Save
                    <i class="material-icons right">archive</i>
                  </button>
                </div>

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
@stop
