<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Sign-Up/Login Form</title>
  <link href='https://fonts.googleapis.com/css?family=Titillium+Web:400,300,600' rel='stylesheet' type='text/css'>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/normalize.min.css') }}">
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <style>
    #error,#error1,#succ{
      display: none;
    }
  </style>
  <link rel="stylesheet" href="{{ asset('css/materialize.min.css') }}">
</head>

<body>
  <div class="form">

      <ul class="tab-group">
        <li class="tab active"><a href="#signup">Daftar</a></li>
        <li class="tab"><a href="#login">Log In</a></li>
        <li class="tab"><a href="#info">Info</a></li>
      </ul>

      <div class="row" id="succ">
        <div class="col s12 m10 l10 offset-m1 offset-l1">
            <div class="chip green darken-3" style="padding: 10px 10px 10px 10px; width: 100%; height:100%; border-radius:0px;">
                <i class=" close material-icons right white-text">close</i>
                <div class="white-text"><b>Success : </b> <p id="suc"></p></div>
            </div>
        </div>
      </div>

      <div class="tab-content">
        <div class="row" id="error">
          <div class="col s12 m10 l10 offset-m1 offset-l1">
              <div class="chip red darken-1" style="padding: 10px 10px 10px 10px; width: 100%; height:100%; border-radius:0px;">
                  <i class=" close material-icons right white-text">close</i>
                  <div class="white-text"><b>Error : </b> <p id="err"></p></div>
              </div>
          </div>
        </div>

        <div id="login">
          <h1>Log In</h1>
          <form action="/" method="post" id="log">
            <div class="field-wrap input-field">
              <input type="text" name="username" required autocomplete="off" id="luname"/>
              <label for="luname">
                Username<span class="req">*</span>
              </label>
            </div>

            <div class="field-wrap input-field">
              <input type="password" name="password" required autocomplete="off" id="lpass"/>
              <label for="lpass">
                Password<span class="req">*</span>
              </label>
            </div>
            <button class="button button-block" id="log_in"/>Log In</button>
          </form>
        </div>

        <div id="signup">
          @if(isset($mulai))
              <h5 style="color:white">Pendaftaran dimulai pada tanggal:</h5>
              <h1>{{$mulai}}</h1>
          @elseif(isset($akhir))
              <h5 style="color:white">Pendaftaran telah berakhir pada tanggal:</h5>
              <h1>{{$akhir}}</h1>
          @else
              <div class="row" id="error1">
                <div class="col s12 m10 l10 offset-m1 offset-l1">
                    <div class="chip red darken-1" style="padding: 10px 10px 10px 10px; width: 100%; height:100%; border-radius:0px;">
                        <i class=" close material-icons right white-text">close</i>
                        <div class="white-text"><b>Error : </b> <p id="err1"></p></div>
                    </div>
                </div>
              </div>

              <h1>Form pendaftaran</h1>

              <form action="/" id="form_daftar">
                <div class="field-wrap input-field">
                  <input type="text" required autocomplete="off" id="duname" name="username" />
                  <label for="duname">Username<span class="req">*</span></label>
                </div>

                <div class="field-wrap input-field">
                    <input type="password" required autocomplete="off" name="password" id="dpass"/>
                    <label for="dpass">
                      Password<span class="req">*</span>
                    </label>
                </div>
                <p>
                    <input type="checkbox" id="showpass" class="filled-in mat"/>
                    <label for="showpass" class="check">Show password</label>
                <p>
                <div class="field-wrap input-field">
                  <input type="email" required autocomplete="off" name="email" id="dmail"/>
                  <label for="dmail">
                    Email Address<span class="req">*</span>
                  </label>
                </div>
                {!! NoCaptcha::display() !!}
                <button type="submit" class="button button-block" id="daftar"/>Daftar</button>
              </form>
          @endif
        </div>

        <div id="info">
          <h1>Informasi</h1>
          <span class="white-text">Informasi untuk penerimaan siswa baru tahun {{$ajaran}}:</span>
          <ul class="collapsible" data-collapsible="accordion">
             <li>
               <div class="collapsible-header">Kapan Pendaftaran Siswa Dibuka?</div>
               <div class="collapsible-body"><span class="white-text">Pendaftaran akan dimulai pada {{$tgl_mulai}}</span></div>
             </li>
             <li>
               <div class="collapsible-header">Kapan Pendaftaran Siswa Ditutup?</div>
               <div class="collapsible-body"><span class="white-text">Pendaftaran akan ditutup pada {{$tgl_akhir}}</span></div>
             </li>
             <li>
               <div class="collapsible-header">Kapan Calon Siswa Bisa Melihat Hasil?</div>
               <div class="collapsible-body"><span class="white-text">Pembukaan penerimaan akan dibuka pada {{$tgl_pembukaan}}</span></div>
             </li>
             <li>
               <div class="collapsible-header">Dimana Calon Siswa Bisa Melihat Hasilnya?</div>
               <div class="collapsible-body"><span class="white-text">Calon Siswa bisa melihat hasilnya di dashboard masing-masing</span></div>
             </li>
             <li>
               <div class="collapsible-header">Berapa Jumlah Calon Siswa Yang Akan Diterima?</div>
               <div class="collapsible-body"><span class="white-text">Calon Siswa yang akan diterima berjumlah {{$kuota}} orang</span></div>
             </li>
           </ul>

        </div>

      </div><!-- tab-content -->

</div> <!-- /form -->
  <script src="{{ asset('js/jquery.min.js') }}"></script>
  <script  src="{{ asset('js/materialize.min.js') }}"></script>
  <script>
  $(document).ready(function(){
    $('ul.tab-group').tabs();
    $("#showpass").on("click",function(){
      if($(this).prop("checked")){
        $("#dpass").attr("type","text");
      }
      else{
        $("#dpass").attr("type","password");
      }
    });

      $("#daftar").on("click",function(e){
          e.preventDefault();
          var data = $("#form_daftar").serialize();
          $.ajax({
            url: "daftar",
            type: "post",
            data: data,
            success: function(result){
              var ret = $.parseJSON(result);
              if(ret["code"] == 403){
                $("#error1 .card-title").html("Error");
                $("#error1").css("display","block");
                $("#succ").css("display","none");
                $("#err1").html(ret["msg"].join("<br>"));
              }
              else{
                $("#error1").css("display","none");
                $("#suc").html(ret["msg"]);
                $("#succ").css("display","block");
              }
          }});
      });

      $("#log_in").on("click",function(e){
          e.preventDefault();
          var data = $("#log").serialize();
          $.ajax({
            url: "auth",
            type: "post",
            data: data,
            success: function(result){
              console.log(result);
              var ret = $.parseJSON(result);
              if(ret["code"] == 403){
                $("#error .card-title").html("Error");
                $("#error").css("display","block");
                $("#succ").css("display","none");
                $("#err").html(ret["msg"]);
              }
              else{
                $("#suc").html(ret["msg"]);
                $("#succ").css("display","block");

                window.location.href = "dashboard";
              }
          }});
      });
  });
  </script>
  {!! NoCaptcha::renderJs() !!}
  <script  src="{{ asset('js/login.js') }}"></script>

</body>
</html>
