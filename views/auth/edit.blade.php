@extends('layouts.panel')
@section('panelTitle', 'Editar Perfil de usuario')
@section('panelBody')
    {!! Form::open(['route' => 'auth.update']) !!}
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('name', 'Nombre completo:') !!}
            {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Su nombre']) !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('email', 'Correo electronico:') !!}
            {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Su direccion de e-mail']) !!}
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{{route('auth.profile')}}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
    {!! Form::close() !!}
@stop
