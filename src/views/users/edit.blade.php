@extends('layouts.panel')
@section('panelTitle', 'Editar datos de usuario')
@section('panelBody')
    {!! Form::open(['route' => ['auth.users.update', $user->id]]) !!}
    {!! Form::hidden('_method', 'PUT') !!}
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('name', 'Nombre:') !!}
            {!! Form::text('name', $user->name, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('email', 'Correo electronico:') !!}
            {!! Form::text('email', $user->email, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('rol', 'Rol:') !!}
            {!! Form::select('rol', $roles, sizeof($user->roles) ? $user->roles->first()->id : old('rol') , ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('estado', 'Estado:') !!}
            {!! Form::select('estado', $estados, $user->estado->id, ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'required' => 'required']) !!}
        </div>
    </div>
    <div class="col-xs-6">
        <div class="form-group">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{{route('auth.users.index')}}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
    {!! Form::close() !!}
@stop
