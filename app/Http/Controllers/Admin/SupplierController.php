<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Supplier;
use App\Models\StockIn;

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
            'nama_supplier' => [
                'required',
                'string',
                'max:255',
                'unique:suppliers,nama_supplier',
            ],

            'kontak_person' => 'nullable',
            'email' => 'nullable|email',
            'telepon' => 'nullable',
            'catatan' => 'nullable',
            'negara' => 'nullable',
            'provinsi' => 'nullable',
            'kota' => 'nullable',
            'kode_pos' => 'nullable',
            'alamat' => 'nullable',
            'status' => 'required|in:Aktif,Nonaktif',

        ], [

            'nama_supplier.required' =>
                'Nama supplier wajib diisi.',

            'nama_supplier.unique' =>
                'Nama supplier sudah terdaftar.',

            'email.email' =>
                'Format email tidak valid.',
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

            'nama_supplier' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers', 'nama_supplier')
                    ->ignore($supplier->id),
            ],

            'kontak_person' => 'nullable',

            'email' => [
                'nullable',
                'email',
            ],

            'telepon' => 'nullable',

            'catatan' => 'nullable',

            'negara' => 'nullable',

            'provinsi' => 'nullable',

            'kota' => 'nullable',

            'kode_pos' => 'nullable',

            'alamat' => 'nullable',

            'status' => 'required|in:Aktif,Nonaktif',

        ], [

            'nama_supplier.required' =>
                'Nama supplier wajib diisi.',

            'nama_supplier.unique' =>
                'Nama supplier sudah terdaftar.',

            'email.email' =>
                'Format email tidak valid.',

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
        // Cek apakah supplier masih digunakan pada data stok masuk
        $digunakan = StockIn::where(
            'supplier_id',
            $supplier->id
        )->exists();

        // Jika masih digunakan, batalkan penghapusan
        if ($digunakan) {
            return redirect()
                ->route('admin.supplier.index')
                ->with(
                    'error',
                    'Supplier tidak dapat dihapus karena masih digunakan pada data stok masuk.'
                );
        }

        // Jika tidak digunakan, supplier boleh dihapus
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