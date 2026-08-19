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
        $opname =
            StockOpname::findOrFail($id);

        $opname->update([

            'status' =>
                $request->status

        ]);

        return back()
            ->with(
                'success',
                'Status berhasil diperbarui'
            );
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