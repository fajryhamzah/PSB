@extends("dashboard.penilai.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Tambah Nilai </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
     <form class="col s12" method="post">
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
         <div class="input-field col s6">
            <select name="ujian" id="ujian">
              @foreach($ujian as $key => $val)
                <option value="{{$val['id_ujian']}}">{{$val['nama_ujian']}}</option>
              @endforeach
            </select>
            <label>Nama Ujian</label>
        </div>
         <div class="input-field col s8">
           <input id="icon_telephone" type="text" name="nodaftar" class="validate">
           <label for="icon_telephone">No Pendaftar</label>
           <input id="auto" type="text" class="validate" disabled>
         </div>
         <div class="input-field col s8">
           <input id="icon_telep" type="number" name="nilai" class="validate">
           <label for="icon_telep">Nilai</label>
         </div>

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

  @section("js")

  function check(){
    var data = "{{url('dashboard')}}/whoisthis/"+$("#icon_telephone").val()+"/siswa/"+$("#ujian").val();
    $("#auto").val("Loading...");
    $.get( data, function( dt ) {
      $("#auto").val(JSON.parse(dt).msg);
    });
  }

  $("#icon_telephone").on("keyup",function(){
    check();
  });

  $("#ujian").on("change",function(){
    check();
  });
  @stop
