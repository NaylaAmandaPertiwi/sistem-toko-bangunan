<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PROFIL ADMIN
    |--------------------------------------------------------------------------
    */

    public function admin()
    {
        $user = Auth::user();

        return view(
            'admin.profil.index',
            compact('user')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | PROFIL KASIR
    |--------------------------------------------------------------------------
    */

    public function kasir()
    {
        $user = Auth::user();

        return view(
            'kasir.profil.index',
            compact('user')
        );
    }
}