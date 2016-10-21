<?php
namespace NachoFassini\Auth;

use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use NachoFassini\Auth\Mail\NewUser;
use NachoFassini\Auth\Mail\PasswordReset;
use NachoFassini\Auth\UserEstados;

/**
 *
 */
class UsersController extends Controller
{
    protected $user;
    protected $roles;

    public function __construct(User $user, Role $role)
    {
        $this->user = $user;
        $this->roles = $role;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $usuarios = $this->user->busqueda()->paginate();
        return view('laravel-ext-auth::users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roles->pluck('display_name', 'id');
        return view('laravel-ext-auth::users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'rol' => 'required|numeric',
        ], [
            'persona_id.unique' => 'La persona ya esta registrada como usuario.',
            'email.unique' => 'El email ya fue registrado por otro usuario.',
        ]);

        $random_password = rand(100000, 999999);

        $user = new User;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->password = bcrypt($random_password);
        $user->remember_token = str_random(10);
        $user->estado_id = UserEstados::where('codigo', 'HAB')->get()->first()->id;
        $user->save();

        $user->attachRole($request->input('rol'));

        Mail::to($user->email, $user->nombre)
            ->send(new NewUser($user, $random_password));

        return redirect()->route('auth.users.index')
            ->with('success', 'Usuario registrado con exito. Recibira un correo electronico con sus credenciales de acceso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $roles = $this->roles->pluck('display_name', 'id');
        $estados = UserEstados::pluck('nombre', 'id');

        return view('laravel-ext-auth::users.edit', compact('user', 'roles', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'email' => 'required|email|max:255|unique:users,email,' . $id . ',id',
                'rol' => 'required|numeric',
                'estado' => 'required|numeric',
            ],
            [
                'email.unique' => 'El correo electronico ya se encuentra en uso por otro usuario. Elija otro.'
            ]
        );

        $user = $this->user->find($id);
        $user->email = $request->input('email');
        $user->estado_id = $request->input('estado');
        $user->save();

        $user->roles()->detach();
        $user->attachRole($request->input('rol'));

        return redirect()->route('auth.users.index')
            ->with('success', 'Datos de perfil actualizados');
    }

    public function editCredenciales($id)
    {
        $user = $this->user->find($id);
        return view('laravel-ext-auth::users.credenciales', ['user' => $user]);
    }

    public function updateCredenciales(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'automaticamente' => 'required|boolean',
                'email' => '',
                'password' => 'required_if:automaticamente,0|same:password-repetir|min:4|max:14|alpha_num',
                'password-repetir' => ''
            ],
            [
                'password.required_if' => 'Si va a definir la contraseña manualmente debe completar el campo contraseña.',
            ]
        );

        $user = $this->user->find($id);
        if ($request->input('automaticamente')) {
            $password = rand(100000, 999999);
            $user->password = bcrypt($password);
        } else {
            $password = $request->input('password');
            $user->password = bcrypt($request->input('password'));
        }
        $user->save();

        if ($request->input('email') || $request->input('automaticamente')) {
            Mail::to($user->email, $user->nombre)
                ->send(new PasswordReset($user, $password));

            return redirect()->route('auth.users.index')
                ->with('success', 'Contraseña actualizada exitosamente. Se ha enviado un mensaje al E-mail ' . $user->email . ' con sus datos de acceso.');
        }

        return redirect()->route('auth.users.index')->with('success', 'Contraseña actualizada exitosamente');
    }
}
