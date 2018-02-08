@extends("dashboard.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Berdasarkan Prestasi </h1></div>
    <!-- Stat Boxes -->
      <div class="row">
        <div class="col s12">
          Kuota Tersisa: {{$kuota}}
          <form name="bulk" method="post">

            <table class="datatable">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Ranking</th>
                  <th>No</th>
                  <th>Nama Siswa</th>
                  <th>Asal Sekolah</th>
                  <th>Total Nilai Prestasi</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </form>
        </div>
      </div>
  </section>
  </main>
@stop

@section("include_js")
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>

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
      dom: 'l<"toolbar">Bfrtip',
      "bLengthChange": false,
      processing: true,
      serverSide: true,
      ajax: '{{ url('/dashboard/list_hasil_prestasi/serverSide') }}',
      initComplete: function(){
        $("div.toolbar").html('<button class="btn waves-effect waves-light" type="submit" name="action">Pilih<i class="material-icons right">send</i></button>');
      }
  });

@stop

@section("include_css")
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>
.toolbar {
    float:left;
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

.icon-align{
  vertical-align: middle;
}
</style>
@stop
