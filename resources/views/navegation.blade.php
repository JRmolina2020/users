<ul class="sidebar-menu" data-widget="tree">
  <li class="header">{{ Auth::user()->email}}</li>
  <li class="treeview">
    <a href="#">
      <i class="fa fa-dashboard"></i> <span>Dashboard</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="../../index.html"><i class="fa fa-circle-o"></i> Dashboard v1</a></li>
      <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li>
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