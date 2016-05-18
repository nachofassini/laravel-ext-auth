@extends('layouts.panel')
@section('panelTitle', 'Administracion de Usuarios')
@section('panelBody')
    <div class="row">
        <div class="col-xs-12">
            <a class="btn btn-default btn-sm pull-right" href="{{route('auth.users.create')}}">
                <i class="fa fa-plus"> Nuevo</i>
            </a>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-xs-12">
            <table class="table table-responsive table-hover table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th>Usuario</th>
                    <th>DNI</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Creado</th>
                </tr>
                </thead>
                <tbody>
                @forelse($usuarios as $item)
                    <tr {{ ($item->estado->codigo == 'BLQ')?'class="warning"':'' }}>
                        <td>
                            <a class="btn btn-default" href="{{route('auth.users.edit', $item->id)}}"
                               title="Click para editar el usuario: {{$item->name}}">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a class="btn btn-warning" href="{{route('auth.users.credenciales.edit', $item->id)}}"
                               title="Click para editar las claves del usuario: {{$item->name}}">
                                <i class="fa fa-lock"></i>
                            </a>
                        </td>
                        <td>{{$item->name}}</td>
                        <td>{{$item->dni}}</td>
                        <td>{{$item->email}}</td>
                        <td>{{$item->roles->first()->display_name or ''}}</td>
                        <td>{{$item->estado->codigo or ''}}</td>
                        <td>{{$item->created_at}}</td>
                    </tr>
                @empty
                    <div class="alert alert-info" role="alert">No se encontraron usuarios registrados.</div>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            {!!$usuarios->render()!!}
        </div>
    </div>
    <div class="modal fade" id="confirm-delete">
        <div class="modal-dialog  modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-question-circle text-danger"></i>&nbsp;Eliminar registro
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        ¿Desea eliminar el registro?<br>
                    </p>
                    <p><span id="resource"></span></p>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['id' => 'destroy', 'method' => 'DELETE']) !!}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Eliminar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-remove"></i>
                        Cancelar
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
