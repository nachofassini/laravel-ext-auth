@extends('emails.layout-auth')

@section('asunto')
    <p>{!! trans('messages.email-asunto.new-user') !!}</p>

    <p>*Usuario: {{ $user->dni }}</p>
    <p>*Contraseña: {{ $password }}</p>
@stop