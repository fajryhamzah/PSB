@extends("dashboard.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Edit Penilai </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
     <form class="col s12" method="post">
       <div class="row">
         <input type="hidden" name="id" value="{{$id}}" />
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
           <i class="material-icons prefix">account_circle</i>
           <input id="icon_prefix" type="text" name="username" class="validate" value="{{$username}}">
           <label for="icon_prefix">Username</label>
         </div>
         <div class="input-field col s8">
           <i class="material-icons prefix">grade</i>
           <input id="icon_telephone" type="password" name="password" class="validate">
           <label for="icon_telephone">Password</label>
         </div>
         <div class="col s3">
           <p style=" display: block;margin-top: 35px;">
             <input type="checkbox" class="filled-in" id="showpass"/>
             <label for="showpass">Show password</label>
          </p>
         </div>
         <div class="input-field col s8">
           <i class="material-icons prefix">mail</i>
           <input id="icon_telep" type="email" name="email" class="validate" value="{{$email}}">
           <label for="icon_telep">Email</label>
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
  $("#showpass").on("click",function(){
    if($(this).prop("checked")){
      $("#icon_telephone").attr("type","text");
    }
    else{
      $("#icon_telephone").attr("type","password");
    }
  });
  @stop
