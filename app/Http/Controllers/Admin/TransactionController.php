<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Sale;
use App\Models\ReturnSale;
use App\Models\User;
use App\Models\Product;
use App\Models\StockMovement;
use App\Models\CashTransaction;

class TransactionController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Controller Penjualan
    |--------------------------------------------------------------------------
    */

    public function penjualan(Request $request)
    {

        $perPage = $request->get('per_page', 10);

        $perPage = $request->integer('per_page', 10);

        $sales = $this->filterSales($request)
            ->paginate($perPage)
            ->withQueryString();

        $cashiers = User::where('role', 'Kasir')
            ->orderBy('name')
            ->get();

        $filter = $request->get('filter', 'all');

        return view(
            'admin.transaksi.penjualan',
            compact(
                'sales',
                'cashiers',
                'filter'
            )
        );
    }

    public function search(Request $request)
    {
        $perPage = $request->get('per_page', 10);

        $perPage = $request->integer('per_page', 10);

        $sales = $this->filterSales($request)
            ->paginate($perPage);

        return response()->json($sales);
    }

    public function searchReturn(Request $request)
    {
        $returns = $this->filterReturns($request)
            ->paginate(
                $request->get('per_page', 10)
            )
            ->withQueryString();

        return response()->json($returns);
    }

    private function filterSales(Request $request)
    {
        $query = Sale::with('user');

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $filter = $request->get('filter', 'all');

        switch ($filter) {

            case 'today':

                $query->whereDate('tanggal', now());

                break;

            case 'yesterday':

                $query->whereDate(
                    'tanggal',
                    now()->subDay()
                );

                break;

            case 'week':

                $query->whereBetween(
                    'tanggal',
                    [
                        now()->subDays(6)->startOfDay(),
                        now()->endOfDay()
                    ]
                );

                break;

            case 'month':

                $query->whereMonth('tanggal', now()->month)
                    ->whereYear('tanggal', now()->year);

                break;

            case 'custom':

                if ($request->filled('tanggal')) {

                    $query->whereDate(
                        'tanggal',
                        $request->tanggal
                    );

                }

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KASIR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kasir')) {

            $query->where('user_id', $request->kasir);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KODE PENJUALAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kode')) {

            $query->where(
                'kode_penjualan',
                'like',
                '%' . trim($request->kode) . '%'
            );

        }

        return $query->latest('tanggal');
    }

    private function filterReturns(Request $request)
    {
        $query = ReturnSale::with([
            'user',
            'sale'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        $filter = $request->get('filter', 'all');

        switch ($filter) {

            case 'today':

                $query->whereDate('tanggal', now());

                break;

            case 'yesterday':

                $query->whereDate(
                    'tanggal',
                    now()->subDay()
                );

                break;

            case 'week':

                $query->whereBetween(
                    'tanggal',
                    [
                        now()->subDays(6)->startOfDay(),
                        now()->endOfDay()
                    ]
                );

                break;

            case 'month':

                $query->whereMonth(
                    'tanggal',
                    now()->month
                )->whereYear(
                    'tanggal',
                    now()->year
                );

                break;

            case 'custom':

                if ($request->filled('tanggal')) {

                    $query->whereDate(
                        'tanggal',
                        $request->tanggal
                    );

                }

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KASIR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kasir')) {

            $query->where(
                'user_id',
                $request->kasir
            );

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER KODE RETUR
        |--------------------------------------------------------------------------
        */

        if ($request->filled('kode')) {

            $query->where(
                'kode_retur',
                'like',
                '%' . trim($request->kode) . '%'
            );

        }

        return $query->latest('tanggal');
    }

    public function show(Sale $sale)
    {
        $sale->load([
            'user',
            'saleDetails.product'
        ]);

        return view(
            'admin.transaksi.detail-penjualan',
            compact('sale')
        );
    }

    public function destroy(Sale $sale)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Cek apakah transaksi sudah memiliki retur
        |--------------------------------------------------------------------------
        */

        $hasReturn = ReturnSale::where(
            'sale_id',
            $sale->id
        )->exists();

        if ($hasReturn) {

            return redirect()
                ->route('admin.transaksi.penjualan')
                ->with(
                    'error',
                    'Transaksi tidak dapat dihapus karena sudah memiliki transaksi retur.'
                );
        }


        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 2. Ambil detail penjualan beserta produk
            |--------------------------------------------------------------------------
            */

            $sale->load([
                'saleDetails.product'
            ]);


            /*
            |--------------------------------------------------------------------------
            | 3. Kembalikan stok produk
            |--------------------------------------------------------------------------
            */

            foreach ($sale->saleDetails as $detail) {

                $product = $detail->product;

                if (!$product) {

                    throw new \Exception(
                        'Produk pada transaksi tidak ditemukan.'
                    );
                }


                $product->increment(
                    'stok',
                    $detail->qty
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 4. Hapus seluruh stock movement berdasarkan kode penjualan
            |--------------------------------------------------------------------------
            */

            StockMovement::where(
                'keterangan',
                'like',
                '%Penjualan ' . $sale->kode_penjualan . '%'
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | 5. Hapus detail penjualan
            |--------------------------------------------------------------------------
            */

            $sale->saleDetails()->delete();


            /*
            |--------------------------------------------------------------------------
            | 6. Hapus transaksi penjualan
            |--------------------------------------------------------------------------
            */

            $sale->delete();


            /*
            |--------------------------------------------------------------------------
            | 7. Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()
                ->route('admin.transaksi.penjualan')
                ->with(
                    'success',
                    'Transaksi penjualan berhasil dihapus dan stok telah dikembalikan.'
                );


        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('admin.transaksi.penjualan')
                ->with(
                    'error',
                    'Transaksi gagal dihapus: ' . $e->getMessage()
                );
        }
    }

    public function showReturn(ReturnSale $returnSale)
    {
        $returnSale->load([
            'user',
            'sale',
            'details.product',
            'exchangeDetails.product'
        ]);

        return view(
            'admin.transaksi.detail-retur',
            compact('returnSale')
        );
    }

    public function destroyReturn(ReturnSale $returnSale)
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Mulai transaksi database
        |--------------------------------------------------------------------------
        */

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | 2. Ambil seluruh detail retur
            |--------------------------------------------------------------------------
            */

            $returnSale->load([
                'details',
                'exchangeDetails'
            ]);


            /*
            |--------------------------------------------------------------------------
            | 3. Kembalikan stok barang yang diretur
            |--------------------------------------------------------------------------
            |
            | Saat retur dibuat:
            |
            | Stok bertambah
            |
            | Maka ketika retur dihapus:
            |
            | Stok harus dikurangi kembali.
            |
            */

            foreach ($returnSale->details as $detail) {

                $product = Product::find(
                    $detail->product_id
                );

                if (!$product) {

                    throw new \Exception(
                        'Produk barang retur tidak ditemukan.'
                    );
                }

                $product->decrement(
                    'stok',
                    $detail->qty
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 4. Kembalikan stok barang pengganti
            |--------------------------------------------------------------------------
            |
            | Saat tukar barang:
            |
            | stok barang pengganti berkurang.
            |
            | Maka ketika retur dihapus:
            |
            | stok harus ditambah kembali.
            |
            */

            foreach ($returnSale->exchangeDetails as $detail) {

                $product = Product::find(
                    $detail->product_id
                );

                if (!$product) {

                    throw new \Exception(
                        'Produk barang pengganti tidak ditemukan.'
                    );
                }

                $product->increment(
                    'stok',
                    $detail->qty
                );
            }


            /*
            |--------------------------------------------------------------------------
            | 5. Hapus stock movement yang berasal dari retur ini
            |--------------------------------------------------------------------------
            |
            | Satu retur dapat menghasilkan:
            |
            | - Movement retur barang
            | - Movement barang pengganti
            |
            | Keduanya menggunakan kode retur sebagai identitas.
            |
            */

            StockMovement::where(
                'keterangan',
                'like',
                '%' . $returnSale->kode_retur . '%'
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | 6. Hapus transaksi kas yang berkaitan dengan retur
            |--------------------------------------------------------------------------
            |
            | Berlaku untuk:
            |
            | - Retur Uang
            | - Selisih pembayaran Tukar Barang
            |
            */

            CashTransaction::where(
                'referensi',
                $returnSale->kode_retur
            )->delete();


            /*
            |--------------------------------------------------------------------------
            | 7. Hapus detail barang retur
            |--------------------------------------------------------------------------
            */

            $returnSale->details()->delete();


            /*
            |--------------------------------------------------------------------------
            | 8. Hapus detail barang pengganti
            |--------------------------------------------------------------------------
            */

            $returnSale->exchangeDetails()->delete();


            /*
            |--------------------------------------------------------------------------
            | 9. Hapus header retur
            |--------------------------------------------------------------------------
            */

            $returnSale->delete();


            /*
            |--------------------------------------------------------------------------
            | 10. Commit
            |--------------------------------------------------------------------------
            */

            DB::commit();


            return redirect()
                ->route('admin.transaksi.retur')
                ->with(
                    'success',
                    'Transaksi retur berhasil dihapus dan stok telah dikembalikan.'
                );


        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('admin.transaksi.retur')
                ->with(
                    'error',
                    'Transaksi retur gagal dihapus: ' . $e->getMessage()
                );
        }
    }                

    public function print(Sale $sale)
    {
        $sale->load([
            'user',
            'saleDetails.product'
        ]);

        return view(
            'shared.print',
            compact('sale')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Controller Retur
    |--------------------------------------------------------------------------
    */

    public function retur(Request $request)
    {
        $returns = $this->filterReturns($request)
            ->paginate(
                $request->get('per_page', 10)
            )
            ->withQueryString();

        $cashiers = User::where('role', 'Kasir')
            ->orderBy('name')
            ->get();

        $filter = $request->get('filter', 'all');

        return view(
            'admin.transaksi.retur',
            compact(
                'returns',
                'cashiers',
                'filter'
            )
        );
    }
}
