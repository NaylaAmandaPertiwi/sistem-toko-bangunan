<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    /**
     * Menampilkan halaman ubah password.
     */
    public function edit()
    {
        return view('password.edit');
    }

    /**
     * Memproses perubahan password.
     */
    public function update(Request $request)
    {
        $request->validate([
            'current_password' => [
                'required',
                'current_password'
            ],

            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed'
            ],
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'current_password.current_password' => 'Password lama tidak sesuai.',

            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);

        $user = Auth::user();

        $user->password = $request->password;
        $user->save();

        return redirect()
            ->route('password.edit')
            ->with(
                'success',
                'Password berhasil diubah.'
            );
    }
}