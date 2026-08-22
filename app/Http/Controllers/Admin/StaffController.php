<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffController extends Controller
{
    /**
     * Menampilkan daftar akun Kasir.
     */
    public function index()
    {
        $kasirs = User::where('role', 'Kasir')
            ->latest()
            ->get();

        return view('admin.staff.index', compact('kasirs'));
    }

    /**
     * Menampilkan form tambah akun Kasir.
     */
    public function create()
    {
        return view('admin.staff.create');
    }

    /**
     * Menyimpan akun Kasir baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ], [

            'name.required' =>
                'Nama Kasir wajib diisi.',

            'username.required' =>
                'Username Kasir wajib diisi.',

            'username.unique' =>
                'Username tersebut sudah digunakan.',

            'password.required' =>
                'Password Kasir wajib diisi.',

            'password.min' =>
                'Password minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak sama.',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => null,
            'password' => Hash::make($validated['password']),
            'role' => 'Kasir',
            'status' => 'Aktif',
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with(
                'success',
                'Akun Kasir berhasil dibuat.'
            );
    }

    /**
     * Menampilkan form reset password Kasir.
     */
    public function resetPasswordForm(User $staff)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan akun yang dipilih adalah Kasir
        |--------------------------------------------------------------------------
        */

        if ($staff->role !== 'Kasir') {

            abort(404);

        }

        return view(
            'admin.staff.reset-password',
            compact('staff')
        );
    }


    /**
     * Memproses reset password Kasir.
     */
    public function resetPassword(Request $request, User $staff)
    {
        /*
        |--------------------------------------------------------------------------
        | Pastikan akun yang dipilih adalah Kasir
        |--------------------------------------------------------------------------
        */

        if ($staff->role !== 'Kasir') {

            abort(404);

        }


        /*
        |--------------------------------------------------------------------------
        | Validasi password baru
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

        ], [

            'password.required' =>
                'Password baru wajib diisi.',

            'password.min' =>
                'Password baru minimal 8 karakter.',

            'password.confirmed' =>
                'Konfirmasi password tidak sama.',

        ]);


        /*
        |--------------------------------------------------------------------------
        | Simpan password baru
        |--------------------------------------------------------------------------
        */

        $staff->update([

            'password' => Hash::make(
                $validated['password']
            ),

        ]);


        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman Staff
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.staff.index')
            ->with(
                'success',
                'Password Kasir berhasil direset.'
            );
    }

    public function deactivate($id)
    {
        $kasir = User::where('id', $id)
            ->where('role', 'Kasir')
            ->firstOrFail();

        $kasir->update([
            'status' => 'Nonaktif',
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with(
                'success',
                'Akun Kasir berhasil dinonaktifkan.'
            );
    }

    public function activate($id)
    {
        $kasir = User::where('id', $id)
            ->where('role', 'Kasir')
            ->firstOrFail();

        $kasir->update([
            'status' => 'Aktif',
        ]);

        return redirect()
            ->route('admin.staff.index')
            ->with(
                'success',
                'Akun Kasir berhasil diaktifkan.'
            );
    }
}