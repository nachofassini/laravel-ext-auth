@extends('laravel-ext-auth::emails.layout-auth')

@section('asunto')
    <p>{!! trans('messages.email-asunto.reset-password') !!}</p>

    <p>*Su contraseña ahora es: {!! $password !!}</p>
@stop
