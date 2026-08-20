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
        $stockOpnames = StockOpname::query();

        if($request->filled('search'))
        {
            $search = $request->search;

            $stockOpnames->where(function($query) use ($search){

                $query->where(
                    'nomor_opname',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'keterangan',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'petugas',
                    'like',
                    "%{$search}%"
                );

            });
        }

        $stockOpnames = $stockOpnames
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

        $request->validate([
            'tanggal_opname' => 'required',
            'petugas' => 'required',
            'status' => 'required',
            'products' => 'required|array|min:1',
        ]);

        $nomorOpname =
            'SO-' .
            now()->format('YmdHis') .
            rand(100,999);

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
                => $request->status
        ]);

        foreach($request->products as $item)
    {
        $selisih =
            $item['stok_fisik']
            -
            $item['stok_sistem'];

        StockOpnameDetail::create([

            'stock_opname_id'
                => $opname->id,

            'product_id'
                => $item['product_id'],

            'stok_sistem'
                => $item['stok_sistem'],

            'stok_fisik'
                => $item['stok_fisik'],

            'selisih'
                => $selisih
        ]);


        Product::where(
            'id',
            $item['product_id']
        )->update([

            'stok'
                => $item['stok_fisik']

        ]);


        StockMovement::create([

            'stock_opname_id'
                => $opname->id,

            'product_id'
                => $item['product_id'],

            'tanggal'
                => $request->tanggal_opname,

            'jenis'
                => 'Opname',

            'qty'
                => $selisih,

            'stok_awal'
                => $item['stok_sistem'],

            'stok_akhir'
                => $item['stok_fisik'],

            'keterangan'
                => 'Stok Opname ' .
                $nomorOpname

        ]);
    }

        return redirect()
            ->route('admin.stok-opname.index');
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

            foreach ($opname->details as $oldDetail) {

        $product = Product::find(
            $oldDetail->product_id
        );

        if (!$product) {

            throw new \Exception(
                'Produk Stock Opname lama tidak ditemukan.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Kembalikan efek Stock Opname lama
        |--------------------------------------------------------------------------
        |
        | Stok sekarang - selisih opname lama
        |
        | Contoh:
        |
        | Stok sekarang = 35
        | Selisih lama  = +5
        |
        | 35 - 5 = 30
        |
        */

        $stokSebelumOpname =
            $product->stok
            -
            $oldDetail->selisih;


        $product->update([

            'stok' => $stokSebelumOpname

        ]);
    }


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


            /*
            |--------------------------------------------------------------------------
            | Simpan stok produk
            |--------------------------------------------------------------------------
            */

            $product->update([

                'stok'
                    => $stokFisik

            ]);


            /*
            |--------------------------------------------------------------------------
            | Buat Stock Movement baru
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
                    => $selisih,

                'stok_awal'
                    => $stokSistem,

                'stok_akhir'
                    => $stokFisik,

                'keterangan'
                    => 'Stok Opname ' .
                       $opname->nomor_opname

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

    public function bulkDelete(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Ambil ID Stock Opname yang dipilih
        |--------------------------------------------------------------------------
        */

        $ids = array_filter(
            explode(',', $request->ids)
        );


        /*
        |--------------------------------------------------------------------------
        | 2. Pastikan ada data yang dipilih
        |--------------------------------------------------------------------------
        */

        if (empty($ids)) {

            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data stok opname yang dipilih.'
            ]);
        }


        /*
        |--------------------------------------------------------------------------
        | 3. Mulai database transaction
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();


        try {

            /*
            |--------------------------------------------------------------------------
            | 4. Ambil semua detail Stock Opname
            |--------------------------------------------------------------------------
            |
            | Kita harus mengambil detail TERLEBIH DAHULU
            | sebelum data detail dihapus.
            |
            */

            $details = StockOpnameDetail::whereIn(
                'stock_opname_id',
                $ids
            )->get();


            /*
            |--------------------------------------------------------------------------
            | 5. Kembalikan stok setiap produk
            |--------------------------------------------------------------------------
            */

            foreach ($details as $detail) {

                $product = Product::find(
                    $detail->product_id
                );


                /*
                |--------------------------------------------------------------------------
                | Pastikan produk masih tersedia
                |--------------------------------------------------------------------------
                */

                if (!$product) {

                    throw new \Exception(
                        'Produk pada stok opname tidak ditemukan.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | Hitung stok setelah Stock Opname dibatalkan
                |--------------------------------------------------------------------------
                |
                | Contoh:
                |
                | Stok sekarang = 31
                | Selisih opname = +1
                |
                | 31 - 1 = 30
                |
                |
                | Contoh selisih negatif:
                |
                | Stok sekarang = 251
                | Selisih opname = -3
                |
                | 251 - (-3) = 254
                |
                */

                $stokSebelumOpname =
                    $product->stok
                    -
                    $detail->selisih;


                /*
                |--------------------------------------------------------------------------
                | Simpan kembali stok produk
                |--------------------------------------------------------------------------
                */

                $product->update([
                    'stok' => $stokSebelumOpname
                ]);
            }


            /*
            |--------------------------------------------------------------------------
            | 6. Hapus Stock Movement milik Stock Opname
            |--------------------------------------------------------------------------
            |
            | Karena sekarang Stock Movement sudah mempunyai
            | stock_opname_id, kita tidak lagi mencari berdasarkan
            | keterangan.
            |
            */

            StockMovement::whereIn(
                'stock_opname_id',
                $ids
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | 7. Hapus detail Stock Opname
            |--------------------------------------------------------------------------
            */

            StockOpnameDetail::whereIn(
                'stock_opname_id',
                $ids
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | 8. Hapus header Stock Opname
            |--------------------------------------------------------------------------
            */

            StockOpname::whereIn(
                'id',
                $ids
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | 9. Simpan seluruh perubahan
            |--------------------------------------------------------------------------
            */

            DB::commit();


            /*
            |--------------------------------------------------------------------------
            | 10. Berikan response berhasil
            |--------------------------------------------------------------------------
            */

            return response()->json([
                'success' => true,
                'message' =>
                    'Data stok opname berhasil dihapus, stok produk dikembalikan, dan pergerakan stok dibersihkan.'
            ]);


        } catch (\Exception $e) {


            /*
            |--------------------------------------------------------------------------
            | 11. Batalkan seluruh perubahan jika terjadi error
            |--------------------------------------------------------------------------
            */

            DB::rollBack();


            return response()->json([
                'success' => false,
                'message' =>
                    'Data stok opname gagal dihapus: ' .
                    $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(
        Request $request,
        $id
    )
    {
        DB::beginTransaction();

        try {

            $opname =
                StockOpname::findOrFail($id);

            $statusSebelumnya =
                $opname->status;


            if (
                $statusSebelumnya === 'Dibatalkan'
                &&
                $request->status !== 'Dibatalkan'
            ) {

                return back()
                    ->with(
                        'error',
                        'Stock Opname yang sudah dibatalkan tidak dapat diubah kembali.'
                    );
            }


            if (
                $request->status === 'Dibatalkan'
                &&
                $statusSebelumnya !== 'Dibatalkan'
            ) {

                $details = StockOpnameDetail::where(
                    'stock_opname_id',
                    $opname->id
                )->get();


                foreach ($details as $detail) {

                    $product = Product::find(
                        $detail->product_id
                    );


                    if (!$product) {

                        throw new \Exception(
                            'Produk pada stok opname tidak ditemukan.'
                        );
                    }


                    $stokSebelumOpname =
                        $product->stok
                        -
                        $detail->selisih;


                    $product->update([
                        'stok' => $stokSebelumOpname
                    ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Hapus Stock Movement milik Stock Opname
                |--------------------------------------------------------------------------
                */

                StockMovement::where(
                    'stock_opname_id',
                    $opname->id
                )->delete();

            }

            $opname->update([

                'status' =>
                    $request->status

            ]);

            DB::commit();

            return back()
                ->with(
                    'success',
                    'Status berhasil diperbarui'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->with(
                    'error',
                    'Status gagal diperbarui: ' .
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