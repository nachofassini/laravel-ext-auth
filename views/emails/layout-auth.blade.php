<html>
    <body>
        <h3>{!! trans('messages.nombre') !!}</h3>

        <h5>Estimado/a {{ $user->name }}:</h5>

        <p>Por favor lea atentamente la siguiente informacion la cual sera necesaria para acceder al sistema y efectuar operaciones con el mismo.</p>

        @section('asunto')
        @show

        <p>
            Para ingresar al sistema haga clic en el siguiente enlace:
            {!! trans('messages.url') !!}
        </p>

        <br>
        {!! trans('messages.email-footer') !!}
    </body>
</html>