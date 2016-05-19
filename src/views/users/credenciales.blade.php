@extends('layouts.panel')
@section('panelTitle', 'Editar credenciales del usuario: "'.$user->name.'"')
@section('panelBody')
    {!! Form::open(['route' => ['auth.users.credenciales.update', $user->id]]) !!}
    {!! Form::hidden('_method', 'PUT') !!}
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('password', 'Nueva contraseña:') !!}
            {!! Form::password('password', ['id' => 'password', 'class' => 'form-control', 'placeholder' => 'Su nueva contraseña', 'disabled' => 'true']) !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            {!! Form::label('password-repetir', 'Repita nueva contraseña:') !!}
            {!! Form::password('password-repetir', ['id' => 'password-repetir', 'class' => 'form-control', 'placeholder' => 'Repita su nueva contraseña', 'disabled' => 'true']) !!}
        </div>
    </div>
    <div class="col-md-3 col-xs-12">
        <div class="input-group">
        <span class="input-group-addon">
          <input type="radio" name="automaticamente"
                 value="1" {!! old('automaticamente') !== '0' ? 'checked="checked"' : '' !!}>
        </span>
            <input type="text" class="form-control" value="Generar Automaticamente" disabled>
        </div>
    </div>
    <div class="col-md-3 col-xs-12">
        <div class="input-group">
        <span class="input-group-addon">
          <input type="radio" name="automaticamente"
                 value="0" {!! old('automaticamente') === '0' ? 'checked="checked"' : '' !!}>
        </span>
            <input type="text" class="form-control" value="Definir manualmente" disabled>
        </div>
    </div>
    <div class="clearfix"></div>
    <br>
    <div class="col-md-3 col-xs-12">
        <div class="input-group">
        <span class="input-group-addon">
          <input type="checkbox" name="email" id="email" checked="checked" disabled="true">
        </span>
            <input type="text" class="form-control" value="Enviar e-mail de notificación al Usuario" disabled="true">
        </div>
    </div>
    <div class="clearfix"></div>
    <br>
    <div class="col-md-6 col-xs-12">
        <div class="form-group">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{{route('auth.users.index')}}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
    {!! Form::close() !!}
@stop
@section('pageScript')
    <script type="text/javascript">
        $(document).ready(function () {
            if ($('input[name=automaticamente]:checked').val() == 1) {
                $('#password').val('');
                $('#password-repetir').val('');
                $('#email').prop('checked', true);
                $('#password').prop('disabled', true);
                $('#password-repetir').prop('disabled', true);
                $('#email').prop('disabled', true);
            } else {
                $('#password').prop('disabled', false);
                $('#password-repetir').prop('disabled', false);
                $('#email').prop('disabled', false);
            }

            $('input[name=automaticamente]').click(function () {
                var automaticamente = $('input[name=automaticamente]:checked').val();
                if (automaticamente == 1) {
                    $('#password').val('');
                    $('#password-repetir').val('');
                    $('#email').prop('checked', true);
                    $('#password').prop('disabled', true);
                    $('#password-repetir').prop('disabled', true);
                    $('#email').prop('disabled', true);
                } else {
                    $('#password').prop('disabled', false);
                    $('#password-repetir').prop('disabled', false);
                    $('#email').prop('disabled', false);
                }
            });
        });
    </script>
@stop
