<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view(
            'admin.supplier.index',
            compact('suppliers')
        );
    }

    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([

            'nama_supplier' => 'required',
            'kontak_person' => 'nullable',
            'email' => 'nullable',
            'telepon' => 'nullable',
            'catatan' => 'nullable',

            'foto' => 'nullable|image',

            'negara' => 'nullable',
            'provinsi' => 'nullable',
            'kota' => 'nullable',
            'kode_pos' => 'nullable',
            'alamat' => 'nullable',
        ]);

        if ($request->hasFile('foto')) {

            $data['foto'] = $request
                ->file('foto')
                ->store('suppliers', 'public');
        }

        Supplier::create($data);

        return redirect()
            ->route('admin.supplier.index')
            ->with('success', 'Supplier berhasil ditambahkan');
    }

    // ==========================
    // EDIT SUPPLIER
    // ==========================
    public function edit(Supplier $supplier)
    {
        return view(
            'admin.supplier.edit',
            compact('supplier')
        );
    }

    // ==========================
    // UPDATE SUPPLIER
    // ==========================
    public function update(
        Request $request,
        Supplier $supplier
    ) {

        $data = $request->validate([

            'nama_supplier' => 'required',
            'kontak_person' => 'nullable',
            'email' => 'nullable',
            'telepon' => 'nullable',
            'catatan' => 'nullable',

            'foto' => 'nullable|image',

            'negara' => 'nullable',
            'provinsi' => 'nullable',
            'kota' => 'nullable',
            'kode_pos' => 'nullable',
            'alamat' => 'nullable',

            'status' => 'nullable'
        ]);

        if ($request->hasFile('foto')) {

            $data['foto'] = $request
                ->file('foto')
                ->store('suppliers', 'public');
        }

        $supplier->update($data);

        return redirect()
            ->route('admin.supplier.index')
            ->with(
                'success',
                'Supplier berhasil diperbarui'
            );
    }

    // ==========================
    // HAPUS SUPPLIER
    // ==========================
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()
            ->route('admin.supplier.index')
            ->with(
                'success',
                'Supplier berhasil dihapus'
            );
    }

    public function export()
    {
        return redirect()
            ->route('admin.supplier.index');
    }
}