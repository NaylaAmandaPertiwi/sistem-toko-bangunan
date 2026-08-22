<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Tampilkan Halaman Login
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        return view('login');
    }


    /*
    |--------------------------------------------------------------------------
    | Proses Login Admin dan Kasir
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $credentials = $request->validate([
            'identifier' => ['required', 'string'],
            'password'   => ['required', 'string'],
        ], [

            'identifier.required' =>
                'Email atau username wajib diisi.',

            'password.required' =>
                'Password wajib diisi.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN JENIS LOGIN
        |--------------------------------------------------------------------------
        |
        | Jika identifier mengandung @
        | → dianggap sebagai email Admin.
        |
        | Jika tidak mengandung @
        | → dianggap sebagai username Kasir.
        |
        */

        $identifier = $credentials['identifier'];

        $password = $credentials['password'];


        /*
        |--------------------------------------------------------------------------
        | LOGIN ADMIN
        |--------------------------------------------------------------------------
        */

        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {

            $login = Auth::attempt([
                'email'    => $identifier,
                'password' => $password,
                'role'     => 'Admin',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN KASIR
        |--------------------------------------------------------------------------
        */

        else {

            /*
            |--------------------------------------------------------------------------
            | CEK AKUN KASIR
            |--------------------------------------------------------------------------
            */

            $kasir = User::where('username', $identifier)
                ->where('role', 'Kasir')
                ->first();


            /*
            |--------------------------------------------------------------------------
            | CEK STATUS KASIR
            |--------------------------------------------------------------------------
            */

            if ($kasir && $kasir->status === 'Nonaktif') {

                return back()
                    ->withInput(
                        $request->only('identifier')
                    )
                    ->withErrors([
                        'identifier' =>
                            'Akun Kasir Anda sedang dinonaktifkan. Silakan hubungi Admin.',
                    ]);

            }


            /*
            |--------------------------------------------------------------------------
            | LOGIN KASIR
            |--------------------------------------------------------------------------
            */

            $login = Auth::attempt([
                'username' => $identifier,
                'password' => $password,
                'role'     => 'Kasir',
                'status'   => 'Aktif',
            ]);

        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN BERHASIL
        |--------------------------------------------------------------------------
        */

        if ($login) {

            $request->session()->regenerate();


            /*
            |--------------------------------------------------------------------------
            | Redirect berdasarkan Role
            |--------------------------------------------------------------------------
            */

            if (Auth::user()->role === 'Admin') {

                return redirect()
                    ->route('admin.dashboard');

            }


            if (Auth::user()->role === 'Kasir') {

                return redirect()
                    ->route('kasir.dashboard');

            }


            /*
            |--------------------------------------------------------------------------
            | Role Tidak Dikenali
            |--------------------------------------------------------------------------
            */

            Auth::logout();

            return redirect('/login')
                ->withErrors([
                    'identifier' =>
                        'Role pengguna tidak dikenali.',
                ]);

        }


        /*
        |--------------------------------------------------------------------------
        | LOGIN GAGAL
        |--------------------------------------------------------------------------
        */

        return back()
            ->withInput(
                $request->only('identifier')
            )
            ->withErrors([
                'identifier' =>
                    'Email/username atau password salah.',
            ]);
    }


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}