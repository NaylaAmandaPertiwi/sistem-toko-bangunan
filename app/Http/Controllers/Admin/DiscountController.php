<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function index(Request $request)
    {
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

    public function create()
    {
        return view('admin.discount.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'nama_diskon' => 'required',
            'minimal_belanja' => 'required|numeric',
            'persentase_diskon' => 'required|numeric',
            'status' => 'required'

        ]);

        Discount::create([

            'nama_diskon' =>
                $request->nama_diskon,

            'minimal_belanja' =>
                $request->minimal_belanja,

            'persentase_diskon' =>
                $request->persentase_diskon,

            'status' =>
                $request->status

        ]);

        return redirect()
            ->route('admin.discount.index')
            ->with(
                'success',
                'Diskon berhasil ditambahkan'
            );
    }

    public function edit($id)
    {
        $diskon = Discount::findOrFail($id);

        return view(
            'admin.discount.edit',
            compact('diskon')
        );
    }

    public function update(
    Request $request,
    Discount $discount
    )
    {
        $discount->update([

            'nama_diskon' => $request->nama_diskon,
            'minimal_belanja' => $request->minimal_belanja,
            'persentase_diskon' => $request->persentase_diskon,
            'status' => $request->status

        ]);

        return redirect()
            ->route('admin.discount.index')
            ->with(
                'success',
                'Diskon berhasil diperbarui'
            );
    }

    public function destroy(
    Discount $diskon
    )
    {
        $diskon->delete();

        return back();
    }
}
