@extends('layouts.panel')
@section('panelTitle', 'Perfil de usuario')
@section('panelBody')
    <ul>
        <li><strong>Nombre: </strong>{{$user->name}}</li>
        <li><strong>DNI: </strong>{{$user->dni}}</li>
        <li><strong>Correo: </strong>{{$user->email}}</li>
        <li><strong>Roles: </strong>
            <ul>
                @forelse ($user->roles as $rol)
                    <li>{{ $rol->name }}</li>
                @empty
                    <p>No tiene roles asignados</p>
                @endforelse
            </ul>
        </li>
    </ul>
@stop
@section('panelFooter')
    <div class="panel-footer">
        <div class="row">
            <div class="col-xs-12">
                <a href="{{route('auth.edit')}}" class="btn btn-primary">Editar</a>
                <a href="{{route('auth.edit-pass')}}" class="btn btn-warning">Cambiar credenciales</a>
            </div>
        </div>
    </div>
@stop
