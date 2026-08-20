<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    // ==========================
    // DAFTAR SUPPLIER
    // ==========================
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {

            $query->where(
                'nama_supplier',
                'like',
                '%' . $request->search . '%'
            );

        }

        $suppliers = $query
            ->latest()
            ->get();

        return view(
            'admin.supplier.index',
            compact('suppliers')
        );
    }

    // ==========================
    // FORM TAMBAH SUPPLIER
    // ==========================
    public function create()
    {
        return view('admin.supplier.create');
    }

    // ==========================
    // SIMPAN SUPPLIER
    // ==========================
    public function store(Request $request)
    {
        $data = $request->validate([

            'nama_supplier' => 'required',

            'kontak_person' => 'nullable',

            'email' => 'nullable',

            'telepon' => 'nullable',

            'catatan' => 'nullable',

            'negara' => 'nullable',

            'provinsi' => 'nullable',

            'kota' => 'nullable',

            'kode_pos' => 'nullable',

            'alamat' => 'nullable',

            'status' => 'required|in:Aktif,Nonaktif',

        ]);

        Supplier::create($data);

        return redirect()
            ->route('admin.supplier.index')
            ->with(
                'success',
                'Supplier berhasil ditambahkan'
            );
    }

    // ==========================
    // FORM EDIT SUPPLIER
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

            'negara' => 'nullable',

            'provinsi' => 'nullable',

            'kota' => 'nullable',

            'kode_pos' => 'nullable',

            'alamat' => 'nullable',

            'status' => 'required|in:Aktif,Nonaktif',

        ]);

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

    // ==========================
    // EXPORT
    // ==========================
    public function export()
    {
        return redirect()
            ->route('admin.supplier.index');
    }
}