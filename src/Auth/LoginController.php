<?php

namespace NachoFassini\Auth;

use App\Http\Controllers\Auth\LoginController as LaravelLoginController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use App\Role;

class LoginController extends LaravelLoginController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after logout.
     *
     * @var string
     */
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
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
     * @param $request
     * @param Authenticatable $user
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, $user)
    {
        $user = User::findOrFail($user->getAuthIdentifier());

        if ($user->habilitado()) {
            return redirect()->intended($this->redirectPath());
        }

        \Auth::logout();
        return redirect('login')
            ->withInput()
            ->withErrors([
                $this->username() => $this->getInhabilitadoLoginMessage(),
            ]);
    }
}
