@extends('layouts.panel')
@section('panelTitle', 'Agregar usuario')
@section('panelBody')
<div class="row">
  <div class="col-xs-12">
    {!! Form::open(['route' => 'auth.users.store']) !!}
      <div class="form-group">
        {!! Form::label('name', 'Nombre:') !!}
        {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => 'Ingrese el nombre del usuario', 'required' => 'required']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('email', 'Email:') !!}
        {!! Form::text('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email', 'required' => 'required']) !!}
      </div>
      <div class="form-group">
        {!! Form::label('rol', 'Rol:') !!}
        {!! Form::select('rol', $roles, old('rol'), ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'required' => 'required']) !!}
      </div>
      <div class="form-group">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a class="btn btn-default btn-small" href="{{ route('auth.users.index') }}">Cancelar</a>
      </div>
    {!! Form::close() !!}
  </div>
</div>
@stop
