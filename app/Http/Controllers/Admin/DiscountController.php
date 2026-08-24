<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Discount;

class DiscountController extends Controller
{
    /**
     * Menampilkan daftar diskon
     */
    public function index(Request $request)
    {
        $today = now()->toDateString();

        Discount::where('status', 'Aktif')
            ->whereDate('tanggal_berakhir', '<', $today)
            ->update([
                'status' => 'Nonaktif'
            ]);

        $discounts = Discount::query();

        if($request->filled('search'))
        {
            $discounts->where(function($query) use ($request){

                $query->where(
                    'nama_diskon',
                    'like',
                    '%' . $request->search . '%'
                )

                ->orWhere(
                    'persentase_diskon',
                    'like',
                    '%' . $request->search . '%'
                );

            });
        }

        $discounts = $discounts
            ->latest()
            ->get();

        return view(
            'admin.discount.index',
            compact('discounts')
        );
    }


    /**
     * Menampilkan form tambah diskon
     */
    public function create()
    {
        return view('admin.discount.create');
    }


    /**
     * Menyimpan diskon baru
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nama_diskon' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('discounts', 'nama_diskon'),
                ],

                'minimal_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'persentase_diskon' => [
                    'required',
                    'numeric',
                    'min:1',
                    'max:100',
                ],

                'tanggal_mulai' => [
                    'required',
                    'date',
                ],

                'tanggal_berakhir' => [
                    'required',
                    'date',
                    'after_or_equal:tanggal_mulai',
                ],

                'status' => [
                    'required',
                    'in:Aktif,Nonaktif',
                ],
            ],
            [
                'nama_diskon.required' =>
                    'Nama diskon wajib diisi.',

                'nama_diskon.unique' =>
                    'Nama diskon tersebut sudah terdaftar.',

                'minimal_belanja.required' =>
                    'Minimal belanja wajib diisi.',

                'minimal_belanja.numeric' =>
                    'Minimal belanja harus berupa angka.',

                'minimal_belanja.min' =>
                    'Minimal belanja tidak boleh kurang dari 0.',

                'persentase_diskon.required' =>
                    'Persentase diskon wajib diisi.',

                'persentase_diskon.min' =>
                    'Persentase diskon minimal 1%.',

                'persentase_diskon.max' =>
                    'Persentase diskon maksimal 100%.',

                'tanggal_mulai.required' =>
                    'Tanggal mulai wajib diisi.',

                'tanggal_berakhir.required' =>
                    'Tanggal berakhir wajib diisi.',

                'tanggal_berakhir.after_or_equal' =>
                    'Tanggal berakhir tidak boleh lebih kecil dari tanggal mulai.',

                'status.required' =>
                    'Status wajib dipilih.',
            ]
        );

        Discount::create([
            'nama_diskon' =>
                $request->nama_diskon,

            'minimal_belanja' =>
                $request->minimal_belanja,

            'persentase_diskon' =>
                $request->persentase_diskon,

            'tanggal_mulai' =>
                $request->tanggal_mulai,

            'tanggal_berakhir' =>
                $request->tanggal_berakhir,

            'status' =>
                $request->status,
        ]);

        return redirect()
            ->route('admin.discount.index')
            ->with(
                'success',
                'Diskon berhasil ditambahkan.'
            );
    }


    /**
     * Menampilkan form edit diskon
     */
    public function edit($id)
    {
        $diskon = Discount::findOrFail($id);

        return view(
            'admin.discount.edit',
            compact('diskon')
        );
    }

    /**
     * Memperbarui diskon
     */
    public function update(
        Request $request,
        Discount $discount
    ) {
        $request->validate(
            [
                'nama_diskon' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('discounts', 'nama_diskon')
                        ->ignore($discount->id),
                ],

                'minimal_belanja' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'persentase_diskon' => [
                    'required',
                    'numeric',
                    'min:1',
                    'max:100',
                ],

                'tanggal_mulai' => [
                    'required',
                    'date',
                ],

                'tanggal_berakhir' => [
                    'required',
                    'date',
                    'after_or_equal:tanggal_mulai',
                ],

                'status' => [
                    'required',
                    'in:Aktif,Nonaktif',
                ],
            ],
            [
                'nama_diskon.required' =>
                    'Nama diskon wajib diisi.',

                'nama_diskon.unique' =>
                    'Nama diskon tersebut sudah terdaftar.',

                'minimal_belanja.required' =>
                    'Minimal belanja wajib diisi.',

                'minimal_belanja.numeric' =>
                    'Minimal belanja harus berupa angka.',

                'minimal_belanja.min' =>
                    'Minimal belanja tidak boleh kurang dari 0.',

                'persentase_diskon.required' =>
                    'Persentase diskon wajib diisi.',

                'persentase_diskon.min' =>
                    'Persentase diskon minimal 1%.',

                'persentase_diskon.max' =>
                    'Persentase diskon maksimal 100%.',

                'tanggal_mulai.required' =>
                    'Tanggal mulai wajib diisi.',

                'tanggal_berakhir.required' =>
                    'Tanggal berakhir wajib diisi.',

                'tanggal_berakhir.after_or_equal' =>
                    'Tanggal berakhir tidak boleh lebih kecil dari tanggal mulai.',

                'status.required' =>
                    'Status wajib dipilih.',
            ]
        );

        $discount->update([
            'nama_diskon' =>
                $request->nama_diskon,

            'minimal_belanja' =>
                $request->minimal_belanja,

            'persentase_diskon' =>
                $request->persentase_diskon,

            'tanggal_mulai' =>
                $request->tanggal_mulai,

            'tanggal_berakhir' =>
                $request->tanggal_berakhir,

            'status' =>
                $request->status,
        ]);

        return redirect()
            ->route('admin.discount.index')
            ->with(
                'success',
                'Diskon berhasil diperbarui.'
            );
    }

    /**
     * Menghapus diskon
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()
            ->route('admin.discount.index')
            ->with(
                'success',
                'Diskon berhasil dihapus.'
            );
    }
}