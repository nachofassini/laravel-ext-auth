<?php
namespace NachoFassini\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Mail;
use NachoFassini\Auth\Usuarios;
use NachoFassini\Auth\UserEstados;
use App\Role;

/**
 *
 */
class AdminUsuariosController extends Controller
{
    protected $user;
    protected $roles;

    public function __construct(Usuarios $user, Role $roles)
    {
        $this->middleware('auth');

        $this->user = $user;
        $this->roles = $roles;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuarios = $this->user->paginate();

        return view('users.index', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = $this->roles->lists('display_name', 'id');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|max:255',
                'dni' => 'required|numeric|unique:users|digits_between:7,10',
                'email' => 'required|email|max:255|unique:users',
                'rol' => 'required|numeric',
            ]
        );

        $random_password = rand(100000, 999999);

        $user = new Usuarios;
        $user->name = $request->name;
        $user->dni = $request->dni;
        $user->email = $request->email;
        $user->password = bcrypt($random_password);
        $user->remember_token = str_random(10);
        $user->estado_id = UserEstados::where('codigo', 'HAB')->get()->first()->id;
        $user->save();

        $user->attachRole($request->input('rol'));

        Mail::queue('emails.new-user', ['user' => $user, 'password' => $random_password], function ($message) use ($user) {
            $message->from('noreply@hotel.com.ar', 'Noresponder');
            $message->to($user->email, $user->name);
            $message->subject('Alta de usuario');
        });

        return redirect()->route('auth.users.index')
            ->withSuccess('Usuario registrado con exito. Recibira un correo electronico con sus credenciales de acceso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->user->find($id);
        $roles = $this->roles->lists('display_name', 'id');
        $estados = UserEstados::lists('nombre', 'id');

        return view('users.edit', compact('user', 'roles', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,'.$id.',id',
                'rol' => 'required|numeric',
                'estado' => 'required|numeric',
            ],
            [
                'email.unique' => 'El correo electronico ya se encuentra en uso por otro usuario. Elija otro.'
            ]
        );

        $user = $this->user->find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->estado_id = $request->input('estado');
        $user->save();

        $user->roles()->detach();
        $user->attachRole($request->input('rol'));

        return redirect()->route('auth.users.index')
            ->with('success', 'Datos de perfil actualizados');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dep = $this->dependencia->findOrFail($id);
        $dep->eliminar($id);

        return redirect()->route('auth.dependencia.index')
            ->withSuccess('Acceso eliminado correctamente!');
    }

    public function editCredenciales($id)
    {
        $user = $this->user->find($id);
        return view('users.credenciales', ['user' => $user]);
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
            Mail::queue('emails.reset-password', ['user' => $user, 'password' => $password], function ($message) use ($user) {
                $message->from('noreply@hotel.com.ar', 'Noresponder');
                $message->to($user->email, $user->name);
                $message->subject('Cambio de credenciales');
            });

            return redirect()->route('auth.users.index')
                ->withSuccess('Contraseña actualizada exitosamente. Se ha enviado un mensaje al E-mail '.$user->email.' con sus datos de acceso.');
        }

        return redirect()->route('auth.users.index')->with('success', 'Contraseña actualizada exitosamente');
    }

    public function usersPorCriterio(Request $request)
    {
        $criterio = $request->get('nombre');
        $usuarios = $this->user->where('dni', 'like', '%'.$criterio.'%')
            ->orWhere('name', 'like', '%'.$criterio.'%')
            ->take(12)
            ->get();
        return response()->json($usuarios);
    }
}
