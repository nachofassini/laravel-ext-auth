@extends('layouts.panel')
@section('panelTitle', 'Editar Perfil de usuario')
@section('panelBody')
    {!! Form::open(['route' => 'auth.update-password']) !!}
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('old-password', 'Contraseña antigua:') !!}
            {!! Form::password('old-password', ['class' => 'form-control', 'placeholder' => 'Su actual contraseña']) !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('password', 'Nueva contraseña:') !!}
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Su nueva contraseña']) !!}
        </div>
    </div>
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('password-repetir', 'Repita nueva contraseña:') !!}
            {!! Form::password('password-repetir', ['class' => 'form-control', 'placeholder' => 'Repita su nueva contraseña']) !!}
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
