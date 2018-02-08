@extends("dashboard.penilai.index")
@section("content")
  <main>
  <section class="content">
    <div id="modal1" class="modal">
      <div class="modal-content">
        <h4>Yakin?</h4>
        <p>Apakah anda yaking ingin menghapus data <b id="confirm"></b>?</p>
      </div>
      <div class="modal-footer">
        <a href="#!" id="delLink" class="modal-action modal-close waves-effect waves-green btn-flat">Ya</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat">Tidak</a>
      </div>
    </div>
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Profile Siswa </h1></div>
    <!-- Stat Boxes -->
    <div class="row">
      <div class="col s12">
        <ul class="tabs">
          <li class="tab col s6"><a href="#data">Prestasi yang telah anda nilai</a></li>
          <li class="tab col s6"><a href="#prestasi">Prestasi yang belum dinilai</a></li>
        </ul>

      <div id="data">
        <table class="datatable">
          <thead>
            <tr>
              <th>Nama prestasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

      <div id="prestasi">
        <table class="datatable1">
          <thead>
            <tr>
              <th>Nama prestasi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>

    </div>
  </section>
  </main>
@stop

@section("include_js")
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript">
    function showModal(url,data){
      $("#delLink").attr("href",url);
      $("#confirm").html(data);
      $(".modal").modal().modal('open');
    }
    </script>
@stop

@section("js")
@if (\Session::has('success'))
    var $toastContent = $("<span>{!! \Session::get('success') !!}</span>");
    Materialize.toast($toastContent, 3000,"green lighten-2");
@endif
@if (\Session::has('error'))
    var $toastContent = $("<span>{!! \Session::get('error') !!}</span>");
    Materialize.toast($toastContent, 3000,"red darken-4");
@endif
  $('.datatable').DataTable({
      dom: 'lBfrtip',
      "bLengthChange": false,
      processing: true,
      serverSide: true,
      order: [ [0, 'desc'] ],
      ajax: '{{ url('/dashboard/prestasi/sudahdinilai/')}}'
  });

  var t = $('.datatable1').DataTable({
      dom: 'lBfrtip',
      "bLengthChange": false,
      processing: true,
      serverSide: true,
      order: [ [0, 'desc'] ],
      ajax: '{{ url('/dashboard/prestasi/belumdinilai/')}}',
      "bAutoWidth": false
  });


@stop

@section("include_css")
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
.aktif{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #26a69a;
}

.aktif:hover{
  background-color: #009688;
}

.edit{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #0288d1;
}

.edit:hover{
  background-color: #0277bd;
}

.nonaktif{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #F44336;
}

.nonaktif:hover{
  background-color: #E53935;
}

.hapus{
  display: inline-block;
  border: none;
  border-radius: 2px;
  color: #fff;
  background-color: #C62828;
}

.hapus:hover{
  background-color: #B71C1C;
}

.icon-align{
  vertical-align: text-bottom;
}
</style>
@stop
