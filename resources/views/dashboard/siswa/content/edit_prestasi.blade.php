@extends("dashboard.siswa.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Edit Prestasi </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
     <form class="col s12" method="post" enctype="multipart/form-data">
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
         <input type="hidden" name="id" value="{{$id}}">
         <div class="input-field col s8">
           <input id="icon_prefix" type="text" name="nama" class="validate" value="{{$nama}}">
           <label for="icon_prefix">Nama Prestasi</label>
         </div>
         <div class="row">
             <div class="input-field col s12">
               <textarea id="description" class="materialize-textarea" name="det" >{{$det}}</textarea>
               <label for="description">Detail Prestasi</label>
             </div>
         </div>
         <div class="file-field input-field">
            <div class="btn">
              <span>Upload gambar pendukung</span>
              <input type="file" name="dok">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text" value="{{$dokname}}">
            </div>
        </div>

        @if(isset($dok))
          <ul class="collapsible" data-collapsible="accordion">
            <li>
              <div class="collapsible-header"><i class="material-icons">view_day</i>Gambar pendukung</div>
              <div class="collapsible-body"><img class="responsive-img" src="{{$dok}}"></div>
            </li>
          </ul>
        @endif
          <div class="input-field col s8">
            <button class="btn waves-effect waves-light" type="submit" name="action">Submit
              <i class="material-icons right">send</i>
            </button>
          </div>
       </div>
     </form>
    </div>
  </section>
  </main>
  @stop
