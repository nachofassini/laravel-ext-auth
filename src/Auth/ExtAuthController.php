<?php

namespace NachoFassini\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ExtAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    public function show()
    {
        return view('laravel-ext-auth::auth.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('laravel-ext-auth::auth.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $user->id
        ]);

        $user->email = $request->input('email');
        $user->save();

        return redirect()->route('auth.profile')
            ->with('success', 'Datos de perfil actualizados');
    }

    public function editPassword()
    {
        return view('laravel-ext-auth::auth.edit-password', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'old-password' => 'required',
            'password' => 'required|different:old-password|min:4|max:14|alpha_num',
            'password-repetir' => 'required|same:password'
        ]);

        $user = Auth::user();
        if (!Hash::check($request->input('old-password'), $user->password)) {
            return redirect()->back()->withErrors(['La contraseña antigua no coincide con la contraseña registrada']);
        }
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return redirect()->route('auth.profile')->with('success', 'Contraseña actualizada exitosamente');
    }
}
