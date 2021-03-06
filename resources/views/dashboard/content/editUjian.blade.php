@extends("dashboard.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Tambah Ujian </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
     <form class="col s12" method="post">
       <input type="hidden" name="id" value="{{$id}}" />
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
         <div class="input-field col s8">
           <i class="material-icons prefix">label</i>
           <input id="icon_prefix" type="text" name="nama_ujian" class="validate" value="{{$nama_ujian}}">
           <label for="icon_prefix">Nama Ujian</label>
         </div>
         <div class="input-field col s8">
           <i class="material-icons prefix">receipt</i>
           <input id="icon_prefix" type="number" name="persentase" class="validate" value="{{$persentase}}">
           <label for="icon_prefix">Persentase</label>
           (persentase tersisa : {{$sisa}}%)
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
