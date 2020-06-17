<ul class="sidebar-menu" data-widget="tree">
  <li class="header">{{ Auth::user()->email}}</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-users"></i> <span>Seguridad</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="{{ url('usuarios') }}"><i class="fa fa-user"></i>Usuarios</a></li>
      <li><a href="{{ url('roles') }}"><i class="fa fa-rocket"></i> Roles</a></li>
      <li><a href="{{ url('permisos') }}"><i class="fa fa-key"></i> Permisos</a></li>
    </ul>
  </li>
  <li><a href="#" 
    onclick="event.preventDefault(); 
    document.getElementById('logout-form').submit();" href="{{ route('logout') }}">
    <i class="fa fa-circle-o text-red"></i> <span>Salir</span>
  </a></li>
  <form id="logout-form" action="{{route('logout')}}" method="POST" style="display:none;">
    {{ csrf_field() }}
  </form>
</ul>