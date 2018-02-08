<footer class="page-footer">
  <div class="footer-copyright">
    <div class="container">
      © {{\Session::get("thn_ajaran")}} penerimaan siswa baru.
    </div>
  </div>
</footer>

<!-- So this is basically a hack, until I come up with a better solution. autocomplete is overridden
in the materialize js file & I don't want that.
-->
<!-- Yo dawg, I heard you like hacks. So I hacked your hack. (moved the sidenav js up so it actually works) -->
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script  src="{{ asset('js/materialize.min.js') }}"></script>
@yield('include_js')
<script>

// Hide sideNav
  $('.button-collapse').sideNav({
    menuWidth: 300, // Default is 300
    edge: 'left', // Choose the horizontal origin
    closeOnClick: false, // Closes side-nav on <a> clicks, useful for Angular/Meteor
    draggable: true // Choose whether you can drag to open on touch screens
    });
  $(document).ready(function(){
    $('.tooltipped').tooltip({delay: 50});
    @yield('js')
  });
    $('select').material_select();
    $('.collapsible').collapsible();
  </script>
</div>

</body>
</html>
