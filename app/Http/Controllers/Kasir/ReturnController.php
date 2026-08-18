<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ReturnSale;
use App\Models\ReturnDetail;
use App\Models\ReturnExchangeDetail;
use App\Models\StockMovement;
use App\Models\CashTransaction;

class ReturnController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Daftar Retur
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $products = Product::where('stok', '>', 0)
            ->orderBy('nama_produk')
            ->get([
                'id',
                'nama_produk',
                'harga_jual',
                'stok'
            ]);

        return view(
            'kasir.retur.index',
            compact('products')
        );
    }

    public function transactionData(Request $request)
    {
        $query = Sale::with('user');

        /*
        |--------------------------------------------------------------------------
        | Filter Kode Transaksi
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(
                'kode_penjualan',
                'like',
                '%' . trim($request->search) . '%'
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Filter Tanggal
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal')) {

            $query->whereDate(
                'tanggal',
                $request->tanggal
            );

        }

        /*
        |--------------------------------------------------------------------------
        | Ambil Data
        |--------------------------------------------------------------------------
        */

        $limit = $request->integer('limit', 10);

        $offset = $request->integer('offset', 0);

        $total = (clone $query)->count();

        $sales = $query
                    ->latest()
                    ->offset($offset)
                    ->limit($limit)
                    ->get();

        return response()->json([

            'success' => true,

            'data' => $sales,

            'hasMore' => ($offset + $limit) < $total,

            'nextOffset' => $offset + $limit,

            'total' => $total

        ]);
    }

    public function detail(Sale $sale)
    {
        $sale->load([

            'user',

            'saleDetails.product'

        ]);

        return response()->json([

            'success' => true,

            'sale' => $sale

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Form Tambah Retur
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $sales = Sale::with([

            'saleDetails.product'

        ])

        ->latest()

        ->paginate(20);

        return view(

            'kasir.retur.create',

            compact('sales')

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Simpan Retur
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'sale_id' => 'required|exists:sales,id',

            'return_type' => 'required|in:uang,tukar',

            'items' => 'required|array|min:1',

            'items.*.sale_detail_id' => 'required|exists:sale_details,id',

            'items.*.qty' => 'required|integer|min:1',

            'exchange_items' => 'nullable|array',

            'exchange_items.*.product_id' =>
                'required|exists:products,id',

            'exchange_items.*.qty' =>
                'required|integer|min:1',

            'keterangan' =>
                'nullable|string|max:255'

        ]);

        /*
        |--------------------------------------------------------------------------
        | CEK BATAS RETUR 7 HARI
        |--------------------------------------------------------------------------
        */

        $sale = Sale::findOrFail($request->sale_id);

        $returnType = $request->return_type;

        $tanggalPembelian =
            \Carbon\Carbon::parse($sale->tanggal)
                ->startOfDay();

        $batasRetur =
            $tanggalPembelian
                ->copy()
                ->addDays(7);

        $hariIni =
            now()->startOfDay();

        if ($hariIni->greaterThan($batasRetur)) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Retur tidak dapat dilakukan karena transaksi sudah melewati batas waktu 7 hari. ' .
                    'Batas retur: ' .
                    $batasRetur->format('d/m/Y')

            ], 422);

        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI BARANG PENGGANTI
        |--------------------------------------------------------------------------
        */

        if (
            $returnType === 'tukar' &&
            $request->input('exchange_items', []) === []
        ) {

            return response()->json([

                'success' => false,

                'message' =>
                    'Silakan pilih minimal satu barang pengganti.'

            ], 422);

        }

        DB::beginTransaction();

        try {

            $returnSale = ReturnSale::create([

                'kode_retur' =>
                    'RT-' . now()->format('YmdHis'),

                'sale_id' =>
                    $request->sale_id,

                'user_id' =>
                    Auth::id(),

                'return_type' =>
                    $returnType,

                'tanggal' =>
                    now(),

                'total_retur' =>
                    0,

                'total_pengganti' =>
                    0,

                'selisih_bayar' =>
                    0,

                'keterangan' =>
                    $request->keterangan

            ]);

            $totalRetur = 0;

            $items = $request->items;

            foreach ($items as $item) {

                $saleDetail = SaleDetail::where(
                    'id',
                    $item['sale_detail_id']
                )
                ->where(
                    'sale_id',
                    $sale->id
                )
                ->firstOrFail();

                /*
                |--------------------------------------------------------------------------
                | CEK QTY YANG SUDAH PERNAH DIRETUR
                |--------------------------------------------------------------------------
                */

                $qtySudahDiretur = ReturnDetail::where(

                    'sale_detail_id',

                    $saleDetail->id

                )->sum('qty');


                /*
                |--------------------------------------------------------------------------
                | HITUNG QTY YANG MASIH BOLEH DIRETUR
                |--------------------------------------------------------------------------
                */

                $qtyTersediaUntukRetur =

                    $saleDetail->qty

                    -

                    $qtySudahDiretur;


                /*
                |--------------------------------------------------------------------------
                | VALIDASI QTY RETUR
                |--------------------------------------------------------------------------
                */

                if ($item['qty'] > $qtyTersediaUntukRetur) {

                    throw new \Exception(

                        "Qty retur produk {$saleDetail->product->nama_produk} " .

                        "melebihi jumlah yang masih dapat diretur."

                    );

                }

                $subtotal =

                    $item['qty']

                    *

                    $saleDetail->harga;

                $totalRetur += $subtotal;

                ReturnDetail::create([

                    'return_sale_id' =>

                        $returnSale->id,

                    'sale_detail_id' =>

                        $saleDetail->id,

                    'product_id' =>

                        $saleDetail->product_id,

                    'qty' =>

                        $item['qty'],

                    'harga' =>

                        $saleDetail->harga,

                    'subtotal' =>

                        $subtotal

                ]);

                /*
                |--------------------------------------------------------------------------
                | Update Stok Produk
                |--------------------------------------------------------------------------
                */

                $product = Product::findOrFail(
                    $saleDetail->product_id
                );

                $stokAwal = $product->stok;

                $product->increment(
                    'stok',
                    $item['qty']
                );

                $product->refresh();

                $stokAkhir = $product->stok;

                /*
                |--------------------------------------------------------------------------
                | Catat Riwayat Pergerakan Stok
                |--------------------------------------------------------------------------
                */

                StockMovement::create([

                    'product_id' => $product->id,

                    'tanggal' => now(),

                    'jenis' => 'retur',

                    'qty' => $item['qty'],

                    'stok_awal' => $stokAwal,

                    'stok_akhir' => $stokAkhir,

                    'keterangan' =>

                        'Retur Penjualan ' .

                        $returnSale->kode_retur

                ]);

            }

            /*
            |--------------------------------------------------------------------------
            | PROSES BARANG PENGGANTI
            |--------------------------------------------------------------------------
            */

            $totalPengganti = 0;

            if ($returnType === 'tukar') {

                $exchangeItems =
                    $request->input('exchange_items', []);

                foreach ($exchangeItems as $exchangeItem) {

                    /*
                    |--------------------------------------------------------------------------
                    | Ambil produk langsung dari database
                    |--------------------------------------------------------------------------
                    */

                    $productPengganti = Product::findOrFail(
                        $exchangeItem['product_id']
                    );


                    /*
                    |--------------------------------------------------------------------------
                    | Cek stok barang pengganti
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $productPengganti->stok <
                        $exchangeItem['qty']
                    ) {

                        throw new \Exception(

                            "Stok produk {$productPengganti->nama_produk} " .
                            "tidak mencukupi untuk barang pengganti."

                        );

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Ambil harga dari database
                    |--------------------------------------------------------------------------
                    */

                    $hargaPengganti =
                        $productPengganti->harga_jual;


                    /*
                    |--------------------------------------------------------------------------
                    | Hitung subtotal barang pengganti
                    |--------------------------------------------------------------------------
                    */

                    $subtotalPengganti =

                        $exchangeItem['qty']

                        *

                        $hargaPengganti;


                    /*
                    |--------------------------------------------------------------------------
                    | Tambahkan ke total pengganti
                    |--------------------------------------------------------------------------
                    */

                    $totalPengganti +=
                        $subtotalPengganti;

                    /*
                    |--------------------------------------------------------------------------
                    | SIMPAN DETAIL BARANG PENGGANTI
                    |--------------------------------------------------------------------------
                    */

                    ReturnExchangeDetail::create([

                        'return_sale_id' =>
                            $returnSale->id,

                        'product_id' =>
                            $productPengganti->id,

                        'qty' =>
                            $exchangeItem['qty'],

                        'harga' =>
                            $hargaPengganti,

                        'subtotal' =>
                            $subtotalPengganti

                    ]);

                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE STOK BARANG PENGGANTI
                    |--------------------------------------------------------------------------
                    */

                    $stokAwalPengganti =
                        $productPengganti->stok;

                    $productPengganti->decrement(
                        'stok',
                        $exchangeItem['qty']
                    );

                    $productPengganti->refresh();

                    $stokAkhirPengganti =
                        $productPengganti->stok;

                    /*
                    |--------------------------------------------------------------------------
                    | CATAT STOCK MOVEMENT BARANG PENGGANTI
                    |--------------------------------------------------------------------------
                    */

                    StockMovement::create([

                        'product_id' =>
                            $productPengganti->id,

                        'tanggal' =>
                            now(),

                        'jenis' =>
                            'Keluar',

                        'qty' =>
                            $exchangeItem['qty'],

                        'stok_awal' =>
                            $stokAwalPengganti,

                        'stok_akhir' =>
                            $stokAkhirPengganti,

                        'keterangan' =>
                            'Barang pengganti retur ' .
                            $returnSale->kode_retur

                    ]);

                }

            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI NILAI BARANG PENGGANTI
            |--------------------------------------------------------------------------
            */

            if ($returnType === 'tukar') {

                if ($totalPengganti < $totalRetur) {

                    throw new \Exception(

                        "Nilai barang pengganti tidak boleh lebih rendah " .
                        "dari nilai barang yang diretur."

                    );

                }

            }

            /*
            |--------------------------------------------------------------------------
            | HITUNG SELISIH BAYAR
            |--------------------------------------------------------------------------
            */

            $selisihBayar = 0;

            if ($returnType === 'tukar') {

                $selisihBayar =
                    $totalPengganti - $totalRetur;

            }

            $returnSale->update([

                'return_type' =>
                    $returnType,

                'total_retur' =>
                    $totalRetur,

                'total_pengganti' =>
                    $totalPengganti,

                'selisih_bayar' =>
                    $selisihBayar

            ]);

            /*
            |--------------------------------------------------------------------------
            | PENCATATAN TRANSAKSI KAS
            |--------------------------------------------------------------------------
            */

            if ($returnSale->return_type === 'uang') {

                CashTransaction::create([

                    'tanggal' =>
                        $returnSale->tanggal,

                    'jenis' =>
                        'keluar',

                    'sumber' =>
                        'retur_uang',

                    'referensi' =>
                        $returnSale->kode_retur,

                    'nominal' =>
                        $returnSale->total_retur,

                    'keterangan' =>
                        'Pengembalian uang dari transaksi retur ' .
                        $returnSale->kode_retur,

                ]);

            } elseif (
                $returnSale->return_type === 'tukar'
                && $returnSale->selisih_bayar > 0
            ) {

                CashTransaction::create([

                    'tanggal' =>
                        $returnSale->tanggal,

                    'jenis' =>
                        'masuk',

                    'sumber' =>
                        'tukar_barang',

                    'referensi' =>
                        $returnSale->kode_retur,

                    'nominal' =>
                        $returnSale->selisih_bayar,

                    'keterangan' =>
                        'Penerimaan selisih pembayaran tukar barang ' .
                        $returnSale->kode_retur,

                ]);

            }

            DB::commit();

            return response()->json([

                'success' => true,

                'message' => 'Retur berhasil disimpan.',

                'return_sale_id' => $returnSale->id

            ]);

        }

        catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 422);

        }

    }

    /*
    |--------------------------------------------------------------------------
    | Detail Retur
    |--------------------------------------------------------------------------
    */

    public function show(ReturnSale $retur)
    {
        $retur->load(
            'sale',
            'details.product',
            'details.saleDetail',
            'exchangeDetails.product'
        );

        return view(
            'transaksi.detail-retur',
            compact('retur')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Hapus Retur
    |--------------------------------------------------------------------------
    */

    public function destroy(ReturnSale $retur)
    {
        DB::beginTransaction();

        try {

            foreach ($retur->details as $detail) {

                Product::where(
                    'id',
                    $detail->product_id
                )->decrement(
                    'stok',
                    $detail->qty
                );
            }

            $retur->delete();

            DB::commit();

            return redirect()
                ->route('retur.index')
                ->with(
                    'success',
                    'Data retur berhasil dihapus.'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([

                'success' => false,

                'message' => $e->getMessage()

            ], 422);

        }
    }
}