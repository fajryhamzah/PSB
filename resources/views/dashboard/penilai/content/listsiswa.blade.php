@extends("dashboard.penilai.index")
@section("content")
  <main>
  <section class="content">
    <div class="page-announce valign-wrapper"><a href="#" data-activates="slide-out" class="button-collapse valign hide-on-large-only"><i class="material-icons">menu</i></a><h1 class="page-announce-text valign">//Pendaftar </h1></div>
    <!-- Stat Boxes -->
      <div class="row">
        <div class="col s12">

          <table class="datatable">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Siswa</th>
                @foreach($ujian as $a)
                  <th>{{$a->nama_ujian}}</th>
                @endforeach
                <th>aksi</th>
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

@stop

@section("js")
  $('.datatable').DataTable({
      dom: 'lBfrtip',
      "bLengthChange": false,
      processing: true,
      serverSide: true,
      ajax: '{{ url('/dashboard/list_pendaftar/serverSide') }}',
      columns: [
        { data: 'id' },
        { data: 'nama' },
        @foreach($ujian as $a)
          { data: 'u{{$a->id_ujian}}' },
        @endforeach
        { data: 'aksi' }
      ]
  });

@stop

@section("include_css")
<link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
<style>

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
