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
    <li><a href="{{ url('/dashboard/list_prestasi')}}"><i class="material-icons pink-item">thumbs_up_down</i>Nilai Prestasi</a></li>
    <li><a href="{{ url('/dashboard/list_nilai')}}"><i class="material-icons pink-item">school</i>Nilai Ujian</a></li>
    <li><a href="{{ url('/dashboard/list_pendaftar')}}"><i class="material-icons pink-item">assessment</i>Pendaftar</a></li>
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
