<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar login
    public function login()
    {
        return view('auth.login');
    }

    // Procesar login
    public function loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Las credenciales no son correctas.',
        ])->onlyInput('email');
    }

    // Mostrar registro
    public function register()
    {
        return view('auth.register');
    }

    // Procesar registro
    public function registerPost(Request $request)
    {
        $data = $request->validate([
            'nombre'             => ['required', 'string', 'max:255'],
            'clave_institucional' => ['required', 'string', 'max:50', 'unique:users'],
            'email'              => ['required', 'email', 'unique:users'],
            'rol'                => ['required', 'in:admin,maestro,alumno'],
            'password'           => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'nombre'              => $data['nombre'],
            'clave_institucional' => $data['clave_institucional'],
            'email'               => $data['email'],
            'rol'                 => $data['rol'],
            'password'            => Hash::make($data['password']),
            'activo'              => true,
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // Cerrar sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
