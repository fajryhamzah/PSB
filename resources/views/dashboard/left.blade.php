  <ul id="slide-out" class="side-nav fixed z-depth-4">
    <li>
      <div class="userView">
        <div class="background">
          <img src="{{ asset('img/photo1.png') }}">
        </div>
        <a href="#!name"><span class="white-text name">Welcome back,</span></a>
        <a href="#!email"><span class="white-text email">{{$username}}</span></a>
      </div>
    </li>

    <li><a href="{{ url('/dashboard')}}"><i class="material-icons pink-item">dashboard</i>Dashboard</a></li>
    <!--<li><div class="divider"></div></li>

    <li><a class="subheader">Management</a></li>-->
    <li><a href="{{ url('/dashboard/penilai')}}"><i class="material-icons pink-item">thumbs_up_down</i>Penilai</a></li>
    <li><a class="subheader">Siswa</a></li>
    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header" style="padding:0 32px">Seleksi Siswa<i class="material-icons pink-item">content_copy</i></a>
        <div class="collapsible-body">
          <ul>
            <li><a href="{{ url('/dashboard/seleksi')}}">Berdasarkan Nilai</a></li>
            <li><a href="{{ url('/dashboard/seleksiPrestasi')}}">Berdasarkan Prestasi</a></li>
            <li><a href="{{ url('/dashboard/terpilih')}}">Terpilih</a></li>
          </ul>
        </div>
      </li>
    </ul>
    <li><a href="{{ url('/dashboard/siswa')}}"><i class="material-icons pink-item">person</i>Calon Siswa</a></li>
    <li><a href="{{ url('/dashboard/pekerjaan')}}"><i class="material-icons pink-item">group_work</i>Pekerjaan</a></li>
    <li><a href="{{ url('/dashboard/ujian')}}"><i class="material-icons pink-item">school</i>Ujian</a></li>
    <li><a class="subheader">Laporan</a></li>
    <ul class="collapsible collapsible-accordion">
      <li>
        <a class="collapsible-header" style="padding:0 32px">Laporan<i class="material-icons pink-item">trending_up</i></a>
        <div class="collapsible-body">
          <ul>
            <li><a href="{{ url('/laporan/pendaftar')}}">Pendaftar</a></li>
            <li><a href="{{ url('/laporan/diterima')}}">Siswa diterima</a></li>
          </ul>
        </div>
      </li>
    </ul>
    <li><div class="divider"></div></li>
    <li><a href="{{ url('/dashboard/setting')}}"><i class="material-icons pink-item">settings</i>Setting</a></li>
    <li><a href="{{ url('/dashboard/logout')}}"><i class="material-icons pink-item">exit_to_app</i>Log Out</a></li>


    <!--
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header">User Management<i class="material-icons pink-item">person</i></a>
          <div class="collapsible-body">
            <ul>
              <li><a href="userdetails.html">User Detail</a></li>
              <li><a href="recentusers.html">Recent Users</a></li>
              <li><a href="reports.html">Reports</a></li>
            </ul>
          </div>
        </li>
      </ul>
    </li>-->

  </ul>
