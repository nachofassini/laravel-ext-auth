<ul class="nav navbar-nav">
    <li class="user"><a href="javascript:void(0)" title="{{\Auth::user()->name}}"><i class="fa fa-user">&nbsp;</i>{{\Auth::user()->name}}</a></li>
    <li class="menu"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-caret-down">&nbsp;</i>Opciones de Usuario</a>
        <ul class="dropdown-menu">
            <li><a href="{{route('auth.profile')}}" class="button editar">Cambiar mis datos</a></li>
            <li><a href="{{route('auth.logout')}}" class="button eliminar">Cerrar mi sesi&oacute;n</a></li>
        </ul>
    </li>
</ul>
