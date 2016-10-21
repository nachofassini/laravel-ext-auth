<?php

namespace NachoFassini\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

final class LoginController extends Controller
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
    public $loginView = 'laravel-ext-auth::auth.login';
    public $redirectTo = 'admin';

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
     * Show the application login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view($this->loginView);
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
