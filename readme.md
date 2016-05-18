# Autenticacion y permisos

El paquete agrega vistas y metodos para el login de laravel. Tambien provee
metodos para editar perfil y password, todo esta basado en la autenticacion
incluida en laravel. Ademas provee metodos para el login de dependencias.
Por otro lado mediante ```"zizaco/entrust"``` se provee un medio para usar
roles y permisos por roles, la libreria agrega ademas un middleware para
asociar permisos con rutas sin tener que agregarlos middleware en las rutas
de este modo las reglas de acceso pueden ser incorporadas tan tarde como se
desee.

## Instalacion
Como no se esta versionando aun el paquete se debe incluir lo siguiente en
composer.json

```json
require: {
    "NachoFassini/auth": "dev-master",
    "zizaco/entrust": "@dev"
}
```

Se debe requerir entrust por que este paquete no tiene una version estable.

Luego un ```composer install``` sera suficiente.

### Agregar los providers y middleware

Agregar a ```config/app.php``` las siguientes lineas


```php
<?php
'providers' => [
    ...
    NachoFassini\Auth\AuthServiceProvider::class,
    Zizaco\Entrust\EntrustServiceProvider::class,
]
```

Agregar a ```app/Http/Kernel.php``` las siguientes lineas


```php
<?php
    protected $middleware = [
        ...
        \NachoFassini\Auth\Middleware\RolesRoutes::class,
    ];

```

Una vez agregados los middleware, podesmos usar los filtros para verifica
que el usuarios este autenticado y logueado en una dependencia.

Ejemplo:

```php
    Route::group(['middleware' => ['auth']], function () {
        //filtro de usuario
    });
```

## Configuracion

### Manejo de errores

Se agregan vistas para los errores 403 y 404.
Asegurarse de completar las siguientes variables en ```lang/es/messages.php```

```bash
    'nombre' => 'Sistema sistematico',
    'version' => 'v1.0.0',
```

### Migraciones

Una vez agregados los providers agregar las migraciones

```bash
php artisan entrust:migration #Crea migracion para entrust
php artisan auth:table        #Crea migracion para auth
php artisan migrate           #Migrar
php artisan vendor:publish    #Mueve las vistas del paquete a su destino
```

Agregar a ```database/seeds/DatabaseSeeder.php``` la siguiente linea

```php
    ...
    $this->call(NachoFassini\Auth\Seeders\UserEstadosTableSeeder::class);
```

Si se quiere que se actualicen las vistas automaticamente es necesario agregar
la ejecucion de ```vendor:publish``` en composer.json:

```json
{
  "scripts": {
     "post-install-cmd": [
       ...
       "php artisan vendor:publish"
     ],
     "post-update-cmd": [
       ...
       "php artisan vendor:publish"
     ],
  }
}
```

En git se deberian ignorar las siguientes rutas

```bash
resources/views/users/
resources/views/emails/layout-auth.blade.php
resources/views/emails/new-user.blade.php
resources/views/emails/reset-password.blade.php
```

### Mails

Para que funcione el envio de mails al crear usuarios o editar sus credenciales
es necesario habilitar algun metodo para encolar jobs.

Primero ejecutar migracion

```bash
    php artisan queue:table
    php artisan migrate
```

Para escuchar cambios en la cola y enviar las tareas encoladas.
Se pueden usar tres metodos:
    - Queue listen de laravel ("php artisan queue:listen")
    - Kernell y cron ('https://laravel.com/docs/5.2/scheduling#defining-schedules')
    - Suepervisor ('https://laravel.com/docs/5.2/queues#supervisor-configuration')


Luego en el archivo `lang/es/messages.php` hay que asegurarse de que esten
definidas las siguientes variables indispensables para el envio de mails
    - nombre => nombre del sistema
    - url => url de origen del mensaje
    - email-asunto [
        new-user => Asunto del email de creacion de usuario exitoso
        reset-password => Asunto del email de cambio/reset de contraseña
    ]
    - footer => recordar al usuario sobre proteccion de datos personales, etc.

### Roles Models

Los roles y permisos se deben agregar en una migracion, los roles y permisos
deben acompañarse de la creacion de los siguientes modelos(extraido de https://github.com/Zizaco/entrust):

#### Role

Create a Role model inside `app/models/Role.php` using the following example:

```php
<?php namespace App;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
}
```

The `Role` model has three main attributes:
- `name` &mdash; Unique name for the Role, used for looking up role information in the application layer. For example: "admin", "owner", "employee".
- `display_name` &mdash; Human readable name for the Role. Not necessarily unique and optional. For example: "User Administrator", "Project Owner", "Widget  Co. Employee".
- `description` &mdash; A more detailed explanation of what the Role does. Also optional.

Both `display_name` and `description` are optional; their fields are nullable in the database.

#### Permission

Create a Permission model inside `app/models/Permission.php` using the following example:

```php
<?php namespace App;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission
{
}
```

The `Permission` model has the same three attributes as the `Role`:
- `name` &mdash; Unique name for the permission, used for looking up permission information in the application layer. For example: "create-post", "edit-user", "post-payment", "mailing-list-subscribe".
- `display_name` &mdash; Human readable name for the permission. Not necessarily unique and optional. For example "Create Posts", "Edit Users", "Post Payments", "Subscribe to mailing list".
- `description` &mdash; A more detailed explanation of the Permission.

In general, it may be helpful to think of the last two attributes in the form of a sentence: "The permission `display_name` allows a user to `description`."

#### User

Next, use the `EntrustUserTrait` trait in your existing `User` model. For example:

```php
<?php

use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Eloquent
{
    use EntrustUserTrait; // add this trait to your user model

    ...
}
```

This will enable the relation with `Role` and add the following methods `roles()`, `hasRole($name)`, `can($permission)`, and `ability($roles, $permissions, $options)` within your `User` model.

Don't forget to dump composer autoload

```bash
composer dump-autoload
```

**And you are ready to go.**

Los datos de los roles y permisos agregarlos en una migracion
que se debe correr en la migracion por defecto


Finalmente se debe agregar un archivo que indique como se
asociaran los permisos con las rutas, este archivo se debe agregar
en ```config/routes-rules.php``` con una estructura como la siguiente:

```php
<?php
return [
    ['route' => 'admin*', 'permission' => 'administrador'],
    ['route' => 'data*', 'permission' => 'owner'],
];
```
Los ```items``` route definen una ruta que puede ser una string en la que se
puede usar "*" como comodin. Los ```permission``` son los nombres de los
permisos

### Acceso a administracion de usuarios y dependencias

Agregar los links a la administracion de usuarios y sus dependencias

```html
    <li><a href="{{ route('auth.users.index') }}">Usuarios</a></li>
```
