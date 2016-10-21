<ul class="nav navbar-nav">
    <li class="user"><a href="javascript:void(0)" title="{{\Auth::user()->name}}"><i class="fa fa-user">&nbsp;</i>{{\Auth::user()->name}}</a></li>
    <li class="menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down">&nbsp;</i>Opciones de Usuario</a>
        <ul class="dropdown-menu">
            <li><a href="{{route('auth.profile')}}">Cambiar mis datos</a></li>
            <li>
                <a href="{{ url('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Cerrar Sesion
                </a>
                <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </li>
</ul>
