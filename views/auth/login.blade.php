@extends('auth.main')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Ups!</strong> Hubo un problema con sus credenciales.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel panel-login">
                    <div class="panel-heading"><h3>Iniciar Sesión</h3></div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="login-form-side">

                                </div>
                            </div>
                            <div class="col-md-6 login-form-content">
                                <div class="">
                                    <form class="" role="form" method="POST" action="{{ url('/auth/login') }}">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                        <div class="form-group">
                                            <label class="control-label" for="dni">N° de Documento</label>
                                            <input type="text" class="form-control" name="dni" value="{{ old('dni') }}"
                                                   placeholder="Número de documento" required>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label" for="password">Clave
                                                <!--<a class="btn btn-link" href="#" title="¿Olvidaste tu contraseña?">¿Olvidaste tu contraseña?</a>--></label>
                                            <input type="password" class="form-control" name="password"
                                                   placeholder="Su contraseña" required>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <div class="">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input type="checkbox" name="remember"> Recordarme
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" title="Ingresar">Ingresar
                                            </button>
                                            <!--<a class="btn btn-link" href="{ url('/password/email') }}">Olvidaste tu contraseña?</a>-->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
