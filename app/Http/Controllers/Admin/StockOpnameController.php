<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\StockOpname;
use App\Models\StockOpnameDetail;
use App\Models\StockMovement;
use Barryvdh\DomPDF\Facade\Pdf;

class StockOpnameController extends Controller
{
    // Halaman daftar stok opname
    public function index(Request $request)
    {
        $query = StockOpname::query();

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $keyword = $request->search;

            $query->where(function ($q) use ($keyword) {

                $q->where(
                    'nomor_opname',
                    'like',
                    '%' . $keyword . '%'
                )
                ->orWhere(
                    'keterangan',
                    'like',
                    '%' . $keyword . '%'
                );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $filter = $request->get(
            'filter',
            'all'
        );


        switch ($filter) {

            case 'today':

                $query->whereDate(
                    'tanggal_opname',
                    now()
                );

                break;


            case 'yesterday':

                $query->whereDate(
                    'tanggal_opname',
                    now()->subDay()
                );

                break;


            case 'week':

                $query->whereBetween(
                    'tanggal_opname',
                    [
                        now()->subDays(6)->startOfDay(),
                        now()->endOfDay()
                    ]
                );

                break;


            case 'month':

                $query->whereMonth(
                    'tanggal_opname',
                    now()->month
                )
                ->whereYear(
                    'tanggal_opname',
                    now()->year
                );

                break;


            case 'custom':

                if ($request->filled('tanggal')) {

                    $query->whereDate(
                        'tanggal_opname',
                        $request->tanggal
                    );

                }

                break;

        }


        $stockOpnames = $query
            ->latest()
            ->get();


        return view(
            'admin.inventory.stok-opname',
            compact('stockOpnames')
        );
    }

    // Halaman tambah stok opname
    public function create()
    {
        $products = Product::all();

        return view(
            'admin.inventory.create-stock-opname',
            compact('products')
        );
    }

    public function edit($id)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Ambil Stock Opname beserta detailnya
        |--------------------------------------------------------------------------
        */

        $opname = StockOpname::with(
            'details.product'
        )->findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | 2. Pastikan hanya Draft yang boleh diedit
        |--------------------------------------------------------------------------
        */

        if ($opname->status !== 'Draft') {

            return redirect()
                ->route(
                    'admin.stok-opname.show',
                    $opname->id
                )
                ->with(
                    'error',
                    'Stock Opname hanya dapat diedit ketika status masih Draft.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | 3. Ambil semua produk
        |--------------------------------------------------------------------------
        */

        $products = Product::all();


        /*
        |--------------------------------------------------------------------------
        | 4. Tampilkan halaman Edit
        |--------------------------------------------------------------------------
        */

        return view(
            'admin.inventory.edit-stock-opname',
            compact(
                'opname',
                'products'
            )
        );
    }

    // Simpan stok opname
    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Validasi data
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'tanggal_opname' =>
                'required|date',

            'keterangan' =>
                'nullable|string',

            'products' =>
                'required|array|min:1',

            'products.*.product_id' =>
                'required|exists:products,id',

            'products.*.stok_fisik' =>
                'required|numeric|min:0',

        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. Mulai transaction
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | 3. Buat nomor opname
            |--------------------------------------------------------------------------
            */

            $nomorOpname =
                'SO-' .
                now()->format('YmdHis') .
                rand(100,999);


            /*
            |--------------------------------------------------------------------------
            | 4. Semua opname baru selalu dimulai sebagai Draft
            |--------------------------------------------------------------------------
            */

            $opname = StockOpname::create([

                'nomor_opname'
                    => $nomorOpname,

                'tanggal_opname'
                    => $request->tanggal_opname,

                'keterangan'
                    => $request->keterangan,

                'petugas'
                    => auth()->user()->name,

                'status'
                    => 'Draft'

            ]);


            /*
            |--------------------------------------------------------------------------
            | 5. Simpan detail opname
            |--------------------------------------------------------------------------
            */

            foreach ($request->products as $item) {

                /*
                |--------------------------------------------------------------------------
                | Ambil produk langsung dari database
                |--------------------------------------------------------------------------
                */

                $product = Product::find(
                    $item['product_id']
                );


                if (!$product) {

                    throw new \Exception(
                        'Produk stok opname tidak ditemukan.'
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Stok sistem berasal dari database
                |--------------------------------------------------------------------------
                */

                $stokSistem =
                    $product->stok;


                /*
                |--------------------------------------------------------------------------
                | Stok fisik berasal dari hasil opname
                |--------------------------------------------------------------------------
                */

                $stokFisik =
                    $item['stok_fisik'];


                /*
                |--------------------------------------------------------------------------
                | Hitung selisih
                |--------------------------------------------------------------------------
                */

                $selisih =
                    $stokFisik -
                    $stokSistem;


                /*
                |--------------------------------------------------------------------------
                | Simpan detail
                |--------------------------------------------------------------------------
                */

                StockOpnameDetail::create([

                    'stock_opname_id'
                        => $opname->id,

                    'product_id'
                        => $product->id,

                    'stok_sistem'
                        => $stokSistem,

                    'stok_fisik'
                        => $stokFisik,

                    'selisih'
                        => $selisih

                ]);


                /*
                |--------------------------------------------------------------------------
                | PENTING
                |--------------------------------------------------------------------------
                |
                | Draft tidak mengubah stok produk.
                |
                | Tidak ada Product::update()
                | Tidak ada StockMovement::create()
                |
                */
            }


            /*
            |--------------------------------------------------------------------------
            | 6. Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | 7. Kembali ke detail
            |--------------------------------------------------------------------------
            */

            return redirect()
                ->route(
                    'admin.stok-opname.show',
                    $opname->id
                )
                ->with(
                    'success',
                    'Stock Opname berhasil dibuat sebagai Draft.'
                );


        } catch (\Exception $e) {

            DB::rollBack();


            return back()
                ->withInput()
                ->with(
                    'error',
                    'Stock Opname gagal dibuat: ' .
                    $e->getMessage()
                );
        }
    }

    public function update(Request $request, $id)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Validasi data
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'tanggal_opname'
                => 'required|date',

            'keterangan'
                => 'nullable|string',

            'products'
                => 'required|array|min:1',

            'products.*.product_id'
                => 'required|exists:products,id',

            'products.*.stok_sistem'
                => 'required|numeric|min:0',

            'products.*.stok_fisik'
                => 'required|numeric|min:0',

        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. Gunakan database transaction
        |--------------------------------------------------------------------------
        |
        | Semua perubahan harus berhasil.
        | Jika salah satu gagal, semuanya dibatalkan.
        |
        */

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | 3. Ambil Stock Opname beserta detail dan produk
            |--------------------------------------------------------------------------
            */

            $opname = StockOpname::with(
                'details.product'
            )->findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | 4. Pastikan hanya Draft yang boleh diubah
            |--------------------------------------------------------------------------
            */

            if ($opname->status !== 'Draft') {

                throw new \Exception(
                    'Stock Opname hanya dapat diedit ketika status masih Draft.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 5. Simpan ID Stock Opname
            |--------------------------------------------------------------------------
            */

            $opnameId = $opname->id;


            /*
            |--------------------------------------------------------------------------
            | 6. Kembalikan efek Stock Opname lama
            |--------------------------------------------------------------------------
            |
            | Misalnya:
            |
            | stok sekarang = 35
            | stok sistem   = 30
            | stok fisik    = 35
            | selisih       = +5
            |
            | Maka kita kembalikan stok menjadi 30 terlebih dahulu.
            |
            */

        /*
        |--------------------------------------------------------------------------
        | 7. Hapus Stock Movement Opname lama
        |--------------------------------------------------------------------------
        |
        | Karena nanti kita membuat movement baru berdasarkan
        | data Draft yang sudah diedit.
        |
        */

        StockMovement::where(
            'stock_opname_id',
            $opnameId
        )->delete();


        /*
        |--------------------------------------------------------------------------
        | 8. Hapus detail Stock Opname lama
        |--------------------------------------------------------------------------
        */

        $opname->details()->delete();


        /*
        |--------------------------------------------------------------------------
        | 9. Update informasi Header Stock Opname
        |--------------------------------------------------------------------------
        */

        $opname->update([

            'tanggal_opname'
                => $request->tanggal_opname,

            'keterangan'
                => $request->keterangan,

            /*
            | Status tetap Draft.
            */

            'status'
                => 'Draft'

        ]);


        /*
        |--------------------------------------------------------------------------
        | 10. Buat detail dan Stock Movement baru
        |--------------------------------------------------------------------------
        */

        foreach ($request->products as $item) {

            $product = Product::find(
                $item['product_id']
            );


            if (!$product) {

                throw new \Exception(
                    'Produk Stock Opname tidak ditemukan.'
                );
            }


            /*
            |--------------------------------------------------------------------------
            | Pastikan stok sistem berasal dari stok produk
            |--------------------------------------------------------------------------
            |
            | Kita tidak menggunakan nilai stok sistem yang dikirim
            | browser sebagai sumber kebenaran.
            |
            */

            $stokSistem =
                $product->stok;


            $stokFisik =
                $item['stok_fisik'];


            /*
            |--------------------------------------------------------------------------
            | Hitung selisih
            |--------------------------------------------------------------------------
            */

            $selisih =
                $stokFisik
                -
                $stokSistem;


            /*
            |--------------------------------------------------------------------------
            | Simpan detail Stock Opname
            |--------------------------------------------------------------------------
            */

            StockOpnameDetail::create([

                'stock_opname_id'
                    => $opname->id,

                'product_id'
                    => $product->id,

                'stok_sistem'
                    => $stokSistem,

                'stok_fisik'
                    => $stokFisik,

                'selisih'
                    => $selisih

            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 11. Commit
        |--------------------------------------------------------------------------
        */

        DB::commit();


        /*
        |--------------------------------------------------------------------------
        | 12. Kembali ke halaman detail
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.stok-opname.show',
                $opname->id
            )
            ->with(
                'success',
                'Draft Stock Opname berhasil diperbarui.'
            );


    } catch (\Exception $e) {

        /*
        |--------------------------------------------------------------------------
        | Jika terjadi error, batalkan SEMUA perubahan
        |--------------------------------------------------------------------------
        */

        DB::rollBack();


        return back()
            ->withInput()
            ->with(
                'error',
                'Draft Stock Opname gagal diperbarui: ' .
                $e->getMessage()
            );
    }
}

    // Detail stok opname
    public function show($id)
    {
        $opname = StockOpname::with(
            'details.product'
        )->findOrFail($id);

        return view(
            'admin.inventory.show-stock-opname',
            compact('opname')
        );
    }

    /**
     * Hapus Stock Opname yang dipilih.
     *
     * Satu data maupun beberapa data dapat dihapus.
     * Data Draft dapat dihapus.
     */
    public function bulkDelete(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil ID yang dikirim dari JavaScript
        |--------------------------------------------------------------------------
        */

        $ids = $request->input('ids', []);

        /*
        |--------------------------------------------------------------------------
        | Pastikan selalu berbentuk array
        |--------------------------------------------------------------------------
        */

        if (!is_array($ids)) {
            $ids = [$ids];
        }

        $ids = array_values(
            array_filter(
                $ids,
                fn ($id) => is_numeric($id)
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Tidak ada data yang dipilih
        |--------------------------------------------------------------------------
        */

        if (empty($ids)) {

            return response()->json([
                'success' => false,
                'message' => 'Pilih data Stock Opname yang ingin dihapus.'
            ], 422);
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Ambil data berdasarkan ID yang BENAR-BENAR dipilih
            |--------------------------------------------------------------------------
            */

            $opnames = StockOpname::whereIn('id', $ids)
                ->get();

            /*
            |--------------------------------------------------------------------------
            | Pastikan semua ID ditemukan
            |--------------------------------------------------------------------------
            */

            if ($opnames->count() !== count($ids)) {

                throw new \Exception(
                    'Sebagian data Stock Opname tidak ditemukan.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Hanya Draft yang boleh dihapus
            |--------------------------------------------------------------------------
            */

            foreach ($opnames as $opname) {

                if ($opname->status !== 'Draft') {

                    throw new \Exception(
                        'Hanya Stock Opname dengan status Draft yang dapat dihapus.'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Hapus Stock Movement terkait
            |--------------------------------------------------------------------------
            */

            StockMovement::whereIn(
                'stock_opname_id',
                $ids
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | Hapus detail
            |--------------------------------------------------------------------------
            */

            StockOpnameDetail::whereIn(
                'stock_opname_id',
                $ids
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | Hapus header Stock Opname
            |--------------------------------------------------------------------------
            */

            StockOpname::whereIn(
                'id',
                $ids
            )->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => count($ids) === 1
                    ? '1 data Stock Opname berhasil dihapus.'
                    : count($ids) . ' data Stock Opname berhasil dihapus.'
            ]);

        } catch (\Throwable $e) {

            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $opname = StockOpname::findOrFail($id);

            /*
            |--------------------------------------------------------------------------
            | Hanya Draft yang boleh dihapus
            |--------------------------------------------------------------------------
            */

            if ($opname->status !== 'Draft') {

                throw new \Exception(
                    'Hanya Stock Opname berstatus Draft yang dapat dihapus.'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Hapus Stock Movement jika ada
            |--------------------------------------------------------------------------
            */

            StockMovement::where(
                'stock_opname_id',
                $opname->id
            )->delete();

            /*
            |--------------------------------------------------------------------------
            | Hapus detail
            |--------------------------------------------------------------------------
            */

            $opname->details()->delete();

            /*
            |--------------------------------------------------------------------------
            | Hapus header
            |--------------------------------------------------------------------------
            */

            $opname->delete();

            DB::commit();

            return redirect()
                ->route('admin.stok-opname.index')
                ->with(
                    'success',
                    'Stock Opname Draft berhasil dihapus.'
                );

        } catch (\Throwable $e) {

            DB::rollBack();

            return redirect()
                ->route('admin.stok-opname.index')
                ->with(
                    'error',
                    'Stock Opname gagal dihapus: ' .
                    $e->getMessage()
                );
        }
    }

    public function updateStatus(
        Request $request,
        $id
    )
    {
        $request->validate([

            'status' => [
                'required',
                'in:Draft,Disetujui,Selesai,Dibatalkan'
            ]

        ]);


        DB::beginTransaction();


        try {

            $opname =
                StockOpname::with('details')
                    ->findOrFail($id);


            $statusLama =
                $opname->status;


            $statusBaru =
                $request->status;


            /*
            |--------------------------------------------------------------------------
            | Stock Opname yang sudah Dibatalkan tidak dapat diaktifkan kembali
            |--------------------------------------------------------------------------
            */

            if (
                $statusLama === 'Dibatalkan'
            ) {

                return back()
                    ->with(
                        'error',
                        'Stock Opname yang sudah dibatalkan tidak dapat diubah kembali.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Stock Opname yang sudah Selesai
            |--------------------------------------------------------------------------
            |
            | Hanya boleh dibatalkan.
            |
            */

            if (
                $statusLama === 'Selesai'
                &&
                $statusBaru !== 'Dibatalkan'
            ) {

                return back()
                    ->with(
                        'error',
                        'Stock Opname yang sudah selesai tidak dapat diubah ke status lain.'
                    );
            }


            /*
            |--------------------------------------------------------------------------
            | Jika status menjadi Selesai
            |--------------------------------------------------------------------------
            |
            | Baru pada tahap ini stok produk diubah.
            |
            */

            if (
                $statusBaru === 'Selesai'
                &&
                $statusLama !== 'Selesai'
            ) {

                foreach ($opname->details as $detail) {

                    $product = Product::find(
                        $detail->product_id
                    );


                    if (!$product) {

                        throw new \Exception(
                            'Produk pada stok opname tidak ditemukan.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Pastikan stok masih sesuai dengan stok sistem
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $product->stok !=
                        $detail->stok_sistem
                    ) {

                        throw new \Exception(

                            'Stok produk ' .
                            $product->nama_produk .
                            ' telah berubah. Silakan buat opname baru.'

                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Update stok sesuai stok fisik
                    |--------------------------------------------------------------------------
                    */

                    $product->update([

                        'stok'
                            => $detail->stok_fisik

                    ]);


                    /*
                    |--------------------------------------------------------------------------
                    | Catat Stock Movement
                    |--------------------------------------------------------------------------
                    */

                    StockMovement::create([

                        'stock_opname_id'
                            => $opname->id,

                        'product_id'
                            => $product->id,

                        'tanggal'
                            => now(),

                        'jenis'
                            => 'Opname',

                        'qty'
                            => $detail->selisih,

                        'stok_awal'
                            => $detail->stok_sistem,

                        'stok_akhir'
                            => $detail->stok_fisik,

                        'keterangan'
                            => 'Stok Opname ' .
                            $opname->nomor_opname

                    ]);

                }

            }


            /*
            |--------------------------------------------------------------------------
            | Jika Selesai kemudian Dibatalkan
            |--------------------------------------------------------------------------
            |
            | Kembalikan stok ke stok sistem sebelum opname.
            |
            */

            if (
                $statusBaru === 'Dibatalkan'
                &&
                $statusLama === 'Selesai'
            ) {

                foreach ($opname->details as $detail) {

                    $product = Product::find(
                        $detail->product_id
                    );


                    if (!$product) {

                        throw new \Exception(
                            'Produk pada stok opname tidak ditemukan.'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Kembalikan ke stok sebelum opname
                    |--------------------------------------------------------------------------
                    */

                    $product->update([

                        'stok'
                            => $detail->stok_sistem

                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Hapus movement opname
                |--------------------------------------------------------------------------
                */

                StockMovement::where(
                    'stock_opname_id',
                    $opname->id
                )->delete();

            }


            /*
            |--------------------------------------------------------------------------
            | Update status
            |--------------------------------------------------------------------------
            */

            $opname->update([

                'status'
                    => $statusBaru

            ]);


            DB::commit();


            return back()
                ->with(
                    'success',
                    'Status Stock Opname berhasil diperbarui.'
                );


        } catch (\Exception $e) {

            DB::rollBack();


            return back()
                ->with(
                    'error',
                    'Status Stock Opname gagal diperbarui: ' .
                    $e->getMessage()
                );
        }
    }

    public function print($id)
    {
        $opname = StockOpname::with(
            'details.product'
        )->findOrFail($id);

        return view(
            'admin.inventory.print-stock-opname',
            compact('opname')
        );
    }

    public function pdf($id)
    {
        $opname = StockOpname::with(
            'details.product'
        )->findOrFail($id);

        $pdf = Pdf::loadView(
            'admin.inventory.pdf-stock-opname',
            compact('opname')
        );

        return $pdf->download(
            'stok-opname-' .
            $opname->nomor_opname .
            '.pdf'
        );
    }
}