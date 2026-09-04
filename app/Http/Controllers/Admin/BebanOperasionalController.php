<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BebanOperasional;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BebanOperasionalController extends Controller
{
    /**
     * Daftar jenis beban yang diperbolehkan.
     */
    private function jenisBeban()
    {
        return [
            'Listrik',
            'Air',
            'Internet',
            'Gaji/Upah',
            'Transportasi',
            'Pengiriman',
            'Perawatan',
            'ATK',
            'Lainnya',
        ];
    }

    /**
     * Menampilkan halaman pencatatan beban.
     */
    public function index(Request $request)
    {
        $filter = $request->filter ?? 'all';

        $allowedFilters = [
            'all',
            'today',
            'yesterday',
            'week',
            'month',
            'custom',
        ];

        if (!in_array($filter, $allowedFilters)) {
            $filter = 'all';
        }

        /*
        |--------------------------------------------------------------------------
        | Query Data Beban
        |--------------------------------------------------------------------------
        */

        $query = BebanOperasional::query();


        if ($filter === 'today') {

            $query->whereDate(
                'tanggal',
                now()->toDateString()
            );

        } elseif ($filter === 'yesterday') {

            $query->whereDate(
                'tanggal',
                now()->subDay()->toDateString()
            );

        } elseif ($filter === 'week') {

            $query->whereBetween('tanggal', [
                now()->subDays(6)->startOfDay(),
                now()->endOfDay(),
            ]);

        } elseif ($filter === 'month') {

            $query->whereMonth('tanggal', now()->month)
                ->whereYear('tanggal', now()->year);

        } elseif ($filter === 'custom') {

            if (
                $request->filled('tanggal_awal') &&
                $request->filled('tanggal_akhir')
            ) {

                $tanggalAwal = Carbon::parse(
                    $request->tanggal_awal
                )->startOfDay();

                $tanggalAkhir = Carbon::parse(
                    $request->tanggal_akhir
                )->endOfDay();


                // Jika tanggal terbalik, tukarkan
                if ($tanggalAwal->greaterThan($tanggalAkhir)) {

                    [$tanggalAwal, $tanggalAkhir] = [
                        $tanggalAkhir,
                        $tanggalAwal,
                    ];

                }


                $query->whereBetween('tanggal', [
                    $tanggalAwal,
                    $tanggalAkhir,
                ]);

            }

        }


        /*
        |--------------------------------------------------------------------------
        | Data Tabel
        |--------------------------------------------------------------------------
        */

        $bebans = $query
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(8)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Ringkasan
        |--------------------------------------------------------------------------
        */

        $summaryQuery = clone $query;


        $totalBeban = $summaryQuery->sum('nominal');

        $jumlahTransaksi = $summaryQuery->count();


        /*
        |--------------------------------------------------------------------------
        | Total Beban Hari Ini
        |--------------------------------------------------------------------------
        */

        $totalBebanHariIni = BebanOperasional::whereDate(
            'tanggal',
            now()->toDateString()
        )->sum('nominal');


        /*
        |--------------------------------------------------------------------------
        | Jumlah Hari
        |--------------------------------------------------------------------------
        */

        if ($filter === 'today' || $filter === 'yesterday') {

            $jumlahHari = 1;

        } elseif ($filter === 'week') {

            $jumlahHari = 7;

        } elseif ($filter === 'month') {

            $jumlahHari = now()->daysInMonth;

        } elseif (
            $filter === 'custom' &&
            $request->filled('tanggal_awal') &&
            $request->filled('tanggal_akhir')
        ) {

            $tanggalAwalCarbon = Carbon::parse(
                $request->tanggal_awal
            );

            $tanggalAkhirCarbon = Carbon::parse(
                $request->tanggal_akhir
            );

            $jumlahHari =
                $tanggalAwalCarbon->diffInDays(
                    $tanggalAkhirCarbon
                ) + 1;

        } else {

            $tanggalPertama =
                BebanOperasional::min('tanggal');


            if ($tanggalPertama) {

                $jumlahHari =
                    Carbon::parse($tanggalPertama)
                        ->diffInDays(
                            now()->startOfDay()
                        ) + 1;

            } else {

                $jumlahHari = 1;

            }

        }


        $rataRataBebanPerHari =
            $jumlahHari > 0
                ? $totalBeban / $jumlahHari
                : 0;


        /*
        |--------------------------------------------------------------------------
        | Data Tambahan
        |--------------------------------------------------------------------------
        */

        $jenisBeban = $this->jenisBeban();

        $tanggalAwal = $request->tanggal_awal;

        $tanggalAkhir = $request->tanggal_akhir;


        return view(
            'admin.beban.index',
            compact(
                'bebans',
                'jenisBeban',
                'filter',
                'tanggalAwal',
                'tanggalAkhir',
                'totalBeban',
                'totalBebanHariIni',
                'jumlahTransaksi',
                'rataRataBebanPerHari'
            )
        );
    }

    /**
     * Menyimpan pencatatan beban baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'jenis_beban' => [
                'required',
                'string',
                Rule::in($this->jenisBeban()),
            ],

            'nominal' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999999.99',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',

            'jenis_beban.required' => 'Jenis beban wajib dipilih.',
            'jenis_beban.in' => 'Jenis beban yang dipilih tidak valid.',

            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'nominal.min' => 'Nominal harus lebih dari 0.',
            'nominal.max' => 'Nominal terlalu besar.',

            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ]);

        BebanOperasional::create($validated);

        return redirect()
            ->route('admin.beban-operasional.index')
            ->with('success', 'Pencatatan beban berhasil ditambahkan.');
    }

    /**
     * Mengubah pencatatan beban.
     */
    public function update(Request $request, BebanOperasional $bebanOperasional)
    {
        $validated = $request->validate([
            'tanggal' => [
                'required',
                'date',
            ],

            'jenis_beban' => [
                'required',
                'string',
                Rule::in($this->jenisBeban()),
            ],

            'nominal' => [
                'required',
                'numeric',
                'min:1',
                'max:999999999999.99',
            ],

            'keterangan' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ], [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',

            'jenis_beban.required' => 'Jenis beban wajib dipilih.',
            'jenis_beban.in' => 'Jenis beban yang dipilih tidak valid.',

            'nominal.required' => 'Nominal wajib diisi.',
            'nominal.numeric' => 'Nominal harus berupa angka.',
            'nominal.min' => 'Nominal harus lebih dari 0.',
            'nominal.max' => 'Nominal terlalu besar.',

            'keterangan.max' => 'Keterangan maksimal 1000 karakter.',
        ]);

        $bebanOperasional->update($validated);

        return redirect()
            ->route('admin.beban-operasional.index')
            ->with('success', 'Pencatatan beban berhasil diperbarui.');
    }

    /**
     * Menghapus pencatatan beban.
     */
    public function destroy(BebanOperasional $bebanOperasional)
    {
        $bebanOperasional->delete();

        return redirect()
            ->route('admin.beban-operasional.index')
            ->with('success', 'Pencatatan beban berhasil dihapus.');
    }
}