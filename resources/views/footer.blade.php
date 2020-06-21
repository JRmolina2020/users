<script src="{{ asset('js/app.js') }}" ></script>
<script src="{{ asset('js/adminlte.min.js') }}" ></script>
<script>
  @auth
    window.Permissions = {!! json_encode(Auth::user()->allPermissions, true) !!};
  @else
    window.Permissions = [];
  @endauth
</script>
</body>
</html>
