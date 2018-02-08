@extends("dashboard.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">// Laporan diterima </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
        <div class="container">
            <canvas id="myChart" width="600" height="300"></canvas>
        </div>
        <div class="row">
          <div class="col s12" id="con">
            <h5>Laporan pertahun</h5>
            <div class="input-field col s2">
               <select name="status" id="stat" onchange="getTheP()">
                 @foreach($pertahun as $a)
                  <option value="{{$a['tahun_ajaran']}}" selected>{{$a['tahun_ajaran']}}</option>
                 @endforeach
               </select>
               <label>Tahun</label>
             </div>
             <div class="col s12">
               <div class="col s6 tes">
                 <canvas id="myChart1" height="400"></canvas>
               </div>
               <div class="col s6 tes1">
                 <canvas id="myChart2" height="400"></canvas>
               </div>
             </div>
          </div>
          <div class="col s6">
            <table>
              <tr>
                <th>Laporan</th>
                <th>Download</th>
              </tr>
              <tr>
                <td>Laporan diterima</td>
                <td><a class="waves-effect waves-light btn a" id="linkdownload" href=""><i class="material-icons left">file_download</i> Download </a></td>
              </tr>
              <tr>
                <td>Laporan berdasarkan nilai</td>
                <td><a class="waves-effect waves-light btn a" id="linkdownload1" href=""><i class="material-icons left">file_download</i> Download </a></td>
              </tr>
              <tr>
                <td>Laporan berdasarkan prestasi</td>
                <td><a class="waves-effect waves-light btn a" id="linkdownload2" href=""><i class="material-icons left">file_download</i> Download </a></td>
              </tr>
              <tr>
                <td>Laporan nilai</td>
                <td><a class="waves-effect waves-light btn a" id="linkdownload5" href=""><i class="material-icons left">file_download</i> Download </a></td>
              </tr>
              <tr>
                <td>Laporan prestasi</td>
                <td><a class="waves-effect waves-light btn a" id="linkdownload6" href=""><i class="material-icons left">file_download</i> Download </a></td>
              </tr>
            </table>

          </div>
        </div>
    </div>
  </section>
  </main>
@stop
@section("include_css")

@stop
@section("include_js")
  <script src="{{ asset('js/chart.min.js') }}"></script>
  <script type="text/javascript">
    var ctx = document.getElementById("myChart").getContext('2d');

    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: [
            @foreach($thn as $a)
              "{{$a}}",
            @endforeach
          ],
          datasets: [{
              label: 'jumlah diterima',
              data: [
                @foreach($pendaftar as $a)
                    "{{$a}}",
                @endforeach
              ],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255,99,132,1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero:true
                  }
              }]
          }
      }
    });

    function getTheP(){
      var thn = $("#stat option:selected").val();
      $("#linkdownload").attr("href","{{url('laporan/download/diterima/tahun')}}/"+thn);
      $("#linkdownload1").attr("href","{{url('laporan/download/diterima/nilai/tahun')}}/"+thn);
      $("#linkdownload2").attr("href","{{url('laporan/download/diterima/prestasi/tahun')}}/"+thn);
      $("#linkdownload5").attr("href","{{url('laporan/download/diterima/semua/nilai/tahun')}}/"+thn);
      $("#linkdownload6").attr("href","{{url('laporan/download/diterima/semua/prestasi/tahun')}}/"+thn);
      $('#myChart1').remove(); // this is my <canvas> element
      $('#myChart2').remove(); // this is my <canvas> element
      $('.tes').append('<canvas id="myChart1" height="400"></canvas>');
      $('.tes1').append('<canvas id="myChart2" height="400"></canvas>');

      $.get( "{{url('/laporan/diterima')}}/"+thn).done(function(dta){
        dta = dta.split(",");
        var ctx1 = document.getElementById("myChart1").getContext('2d');

        var myBarChart = new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: ["Nilai","Prestasi"],
            datasets: [
              {
                label: "Jumlah",
                backgroundColor: ["#3e95cd","#c45850","#424242"],
                data: dta
              }
            ]
          },
          options: {
            legend: { display: false },
            title: {
              display: true,
              text: 'Penerimaan berdasarkan status'
            }
          }
        });
      });

      $.get( "{{url('/laporan/diterima/gender')}}/"+thn).done(function(dta){
        dta = dta.split(",");
        var ctx1 = document.getElementById("myChart2").getContext('2d');

        var myBarChart = new Chart(ctx1, {
          type: 'pie',
          data: {
            labels: ["Laki-laki","Perempuan","Belum Diisi"],
            datasets: [
              {
                label: "Jumlah",
                backgroundColor: ["#3e95cd","#c45850","#424242"],
                data: dta
              }
            ]
          },
          options: {
            legend: { display: false },
            title: {
              display: true,
              text: 'Penerimaan berdasarkan jenis kelamin'
            }
          }
        });
      });

    }

    getTheP();

  </script>
@stop
@section("js")



@stop
