<?php
namespace NachoFassini\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Contracts\Auth\Authenticatable;
use App\User;
use App\Role;

/**
 *
 */
class ExtAuthController extends AuthController
{
    //public $redirectTo = 'dep/login';
    //public $redirectPath = 'dep/login';

    protected $username = 'dni';

    public function __construct()
    {
        parent::__construct();

        $this->middleware(
            $this->guestMiddleware(),
            ['except' => ['getLogout', 'show', 'edit', 'editPassword', 'update', 'updatePassword']]
        );
    }


    /**
     * Get the user inhabilitado login message.
     *
     * @return string
     */
    protected function getInhabilitadoLoginMessage()
    {
        return 'Usted no esta habilitado para operar en el sistema. Comuniquese con un administrador';
    }

    /**
     * Handle a the autentication to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User
     * @return \Illuminaddte\Http\Response
     */
    protected function authenticated($request, Authenticatable $user)
    {
        $user = User::find($user->getAuthIdentifier());

        if ($user->habilitado()) {
            return redirect()->intended($this->redirectPath());
        }

        Auth::logout();
        return redirect()->route('auth.login')
            ->withInput()
            ->withErrors([
                $this->loginUsername() => $this->getInhabilitadoLoginMessage(),
            ]);
    }

    public function show()
    {
        return view('auth.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('auth.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'name'  => 'required|string',
                'email' => 'required|email'
            ]
        );

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('auth.profile')
            ->withSuccess('Datos de perfil actualizados');
    }

    public function editPassword()
    {
        return view('auth.edit-password', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate(
            $request,
            [
                'old-password' => 'required',
                'password' => 'required|different:old-password|min:4|max:14|alpha_num',
                'password-repetir' => 'required|same:password'
            ]
        );

        $user = Auth::user();
        if (!\Hash::check($request->input('old-password'), $user->password)) {
            return redirect()->back()->withErrors(['La contraseña antigua no coincide con la contraseña registrada']);
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('auth.profile')
            ->withSuccess('Contraseña actualizada exitosamente');
    }
}
