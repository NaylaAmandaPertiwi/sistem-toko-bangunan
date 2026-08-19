<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\StockMovement;
use App\Models\StockIn;
use App\Models\Product;
use App\Models\Supplier;

class StockInController extends Controller
{
    public function index(Request $request)
    {
        $query = StockIn::with([
            'supplier',
            'product'
        ]);

        if($request->start_date && $request->end_date)
        {
            $query->whereBetween(
                'tanggal_masuk',
                [
                    $request->start_date,
                    $request->end_date
                ]
            );
        }

        if($request->filled('search'))
        {
            $search = $request->search;

            $query->where(function($q) use ($search){

                $q->where(
                    'nomor_transaksi',
                    'like',
                    "%{$search}%"
                )

                ->orWhere(
                    'tanggal_masuk',
                    'like',
                    "%{$search}%"
                )

                ->orWhereHas('supplier', function($supplier) use ($search){

                    $supplier->where(
                        'nama_supplier',
                        'like',
                        "%{$search}%"
                    );

                })

                ->orWhereHas('product', function($product) use ($search){

                    $product->where(
                        'nama_produk',
                        'like',
                        "%{$search}%"
                    )

                    ->orWhere(
                        'sku',
                        'like',
                        "%{$search}%"
                    );

                });

            });
        }

        $stockIns = $query->latest()->get();

        return view(
            'admin.inventory.stok-masuk',
            compact('stockIns')
        );
    }

    public function create()
    {
        $products = Product::all();
        $suppliers = Supplier::all();

        return view(
            'admin.inventory.create-stock-in',
            compact(
                'products',
                'suppliers'
            )
        );
    }

    public function store(Request $request)
    {
        $request->validate([

            'nomor_transaksi' => 'required',

            'tanggal_masuk' => 'required',

            'supplier_id' => 'required',

            'product_id' => 'required',

            'jumlah_masuk' => 'required|numeric',

            'harga_beli' => 'required|numeric'

        ]);


        /*
        |--------------------------------------------------------------------------
        | 1. Simpan data Stock In
        |--------------------------------------------------------------------------
        */

        $stockIn = StockIn::create([

            'nomor_transaksi' => $request->nomor_transaksi,

            'tanggal_masuk' => $request->tanggal_masuk,

            'supplier_id' => $request->supplier_id,

            'product_id' => $request->product_id,

            'jumlah_masuk' => $request->jumlah_masuk,

            'harga_beli' => $request->harga_beli,

            'keterangan' => $request->keterangan

        ]);


        /*
        |--------------------------------------------------------------------------
        | 2. Ambil produk
        |--------------------------------------------------------------------------
        */

        $product =
            Product::findOrFail(
                $request->product_id
            );


        /*
        |--------------------------------------------------------------------------
        | 3. Hitung stok
        |--------------------------------------------------------------------------
        */

        $stokAwal =
            $product->stok;

        $stokAkhir =
            $stokAwal +
            $request->jumlah_masuk;


        /*
        |--------------------------------------------------------------------------
        | 4. Update stok produk
        |--------------------------------------------------------------------------
        */

        $product->update([

            'stok' => $stokAkhir

        ]);


        /*
        |--------------------------------------------------------------------------
        | 5. Buat Stock Movement
        |--------------------------------------------------------------------------
        */

        StockMovement::create([

            'stock_in_id'
                => $stockIn->id,

            'product_id'
                => $product->id,

            'tanggal'
                => $request->tanggal_masuk,

            'jenis'
                => 'Masuk',

            'qty'
                => $request->jumlah_masuk,

            'stok_awal'
                => $stokAwal,

            'stok_akhir'
                => $stokAkhir,

            'keterangan'
                => 'Stok Masuk Supplier ' .
                $request->nomor_transaksi

        ]);


        /*
        |--------------------------------------------------------------------------
        | 6. Kembali ke halaman Stock In
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin.stok-masuk.index')
            ->with(
                'success',
                'Data stok masuk berhasil disimpan'
            );
    }

    public function edit($id)
    {
        $stockIn = StockIn::findOrFail($id);

        $products = Product::all();
        $suppliers = Supplier::all();

        return view(
            'admin.inventory.create-stock-in',
            compact(
                'stockIn',
                'products',
                'suppliers'
            )
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([

            'tanggal_masuk' => 'required|date',

            'supplier_id' => 'required',

            'product_id' => 'required',

            'jumlah_masuk' => 'required|numeric|min:1',

            'harga_beli' => 'required|numeric|min:0',

        ]);


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. Ambil data stok masuk
            |--------------------------------------------------------------------------
            */

            $stockIn = StockIn::findOrFail($id);


            /*
            |--------------------------------------------------------------------------
            | 2. Simpan data lama
            |--------------------------------------------------------------------------
            */

            $oldProductId = $stockIn->product_id;

            $oldQty = $stockIn->jumlah_masuk;


            /*
            |--------------------------------------------------------------------------
            | 3. Ambil produk lama
            |--------------------------------------------------------------------------
            */

            $oldProduct = Product::find(
                $oldProductId
            );

            if (!$oldProduct) {

                throw new \Exception(
                    'Produk lama pada stok masuk tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | 4. Ambil produk baru
            |--------------------------------------------------------------------------
            */

            $newProduct = Product::find(
                $request->product_id
            );

            if (!$newProduct) {

                throw new \Exception(
                    'Produk baru tidak ditemukan.'
                );

            }


            /*
            |--------------------------------------------------------------------------
            | 5. Kembalikan stok dari transaksi lama
            |--------------------------------------------------------------------------
            |
            | Contoh:
            |
            | Stok sekarang = 150
            | Stok masuk lama = 50
            |
            | 150 - 50 = 100
            |
            */

            $oldProduct->decrement(
                'stok',
                $oldQty
            );


            /*
            |--------------------------------------------------------------------------
            | 6. Tambahkan stok berdasarkan transaksi baru
            |--------------------------------------------------------------------------
            |
            | Jika produk tetap sama:
            |
            | 100 + jumlah baru
            |
            | Jika produk diganti:
            |
            | produk lama dikurangi
            | produk baru ditambah
            |
            */

            $newStokAwal = $newProduct->stok;

            $newStokAkhir =
                $newStokAwal +
                $request->jumlah_masuk;


            $newProduct->update([

                'stok' => $newStokAkhir

            ]);


            /*
            |--------------------------------------------------------------------------
            | 7. Update data stok masuk
            |--------------------------------------------------------------------------
            */

            $stockIn->update([

                'tanggal_masuk'
                    => $request->tanggal_masuk,

                'supplier_id'
                    => $request->supplier_id,

                'product_id'
                    => $request->product_id,

                'jumlah_masuk'
                    => $request->jumlah_masuk,

                'harga_beli'
                    => $request->harga_beli,

                'keterangan'
                    => $request->keterangan

            ]);


            /*
            |--------------------------------------------------------------------------
            | 8. Update stock movement
            |--------------------------------------------------------------------------
            */

            $stockMovement = StockMovement::where(
                'stock_in_id',
                $stockIn->id
            )->first();


            if (!$stockMovement) {

                throw new \Exception(
                    'Pergerakan stok untuk transaksi ini tidak ditemukan.'
                );

            }


            $stockMovement->update([

                'product_id'
                    => $newProduct->id,

                'tanggal'
                    => $request->tanggal_masuk,

                'jenis'
                    => 'Masuk',

                'qty'
                    => $request->jumlah_masuk,

                'stok_awal'
                    => $newStokAwal,

                'stok_akhir'
                    => $newStokAkhir,

                'keterangan'
                    => 'Stok Masuk Supplier ' .
                    $stockIn->nomor_transaksi

            ]);


            /*
            |--------------------------------------------------------------------------
            | 9. Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()
                ->route('admin.stok-masuk.index')
                ->with(
                    'success',
                    'Data stok masuk berhasil diperbarui, stok produk dan pergerakan stok telah disesuaikan.'
                );


        } catch (\Exception $e) {

            DB::rollBack();


            return redirect()
                ->route('admin.stok-masuk.index')
                ->with(
                    'error',
                    'Data stok masuk gagal diperbarui: ' .
                    $e->getMessage()
                );

        }
    }

    public function bulkDelete(Request $request)
    {
        $ids = array_filter(
            explode(',', $request->ids)
        );

        if (empty($ids)) {

            return redirect()
                ->route('admin.stok-masuk.index')
                ->with(
                    'error',
                    'Tidak ada data stok masuk yang dipilih.'
                );
        }

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 1. Ambil semua data stok masuk yang akan dihapus
            |--------------------------------------------------------------------------
            */

            $stockIns = StockIn::whereIn(
                'id',
                $ids
            )->get();


            /*
            |--------------------------------------------------------------------------
            | 2. Proses setiap stok masuk
            |--------------------------------------------------------------------------
            */

            foreach ($stockIns as $stockIn) {

                /*
                |--------------------------------------------------------------------------
                | Ambil produk
                |--------------------------------------------------------------------------
                */

                $product = Product::find(
                    $stockIn->product_id
                );

                if (!$product) {

                    throw new \Exception(
                        'Produk pada stok masuk tidak ditemukan.'
                    );
                }


                /*
                |--------------------------------------------------------------------------
                | 3. Kembalikan stok ke kondisi sebelum stok masuk
                |--------------------------------------------------------------------------
                */

                $product->decrement(
                    'stok',
                    $stockIn->jumlah_masuk
                );


                /*
                |--------------------------------------------------------------------------
                | 4. Hapus stock movement stok masuk
                |--------------------------------------------------------------------------
                */

                StockMovement::where(
                    'product_id',
                    $stockIn->product_id
                )
                ->where(
                    'jenis',
                    'Masuk'
                )
                ->where(
                    'keterangan',
                    'Stok Masuk Supplier ' . $stockIn->nomor_transaksi
                )
                ->delete();


                /*
                |--------------------------------------------------------------------------
                | 5. Hapus data stok masuk
                |--------------------------------------------------------------------------
                */

                $stockIn->delete();
            }


            /*
            |--------------------------------------------------------------------------
            | 6. Simpan perubahan
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()
                ->route('admin.stok-masuk.index')
                ->with(
                    'success',
                    'Data stok masuk berhasil dihapus, stok produk dikembalikan, dan pergerakan stok dibersihkan.'
                );


        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('admin.stok-masuk.index')
                ->with(
                    'error',
                    'Data stok masuk gagal dihapus: ' .
                    $e->getMessage()
                );
        }
    }
}
