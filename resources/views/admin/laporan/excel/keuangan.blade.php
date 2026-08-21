<table>

    {{-- =========================================================
         LEBAR KOLOM
    ========================================================== --}}

    <colgroup>

        <col style="width:45px;">
        <col style="width:95px;">
        <col style="width:155px;">
        <col style="width:155px;">
        <col style="width:95px;">
        <col style="width:115px;">
        <col style="width:120px;">
        <col style="width:135px;">
        <col style="width:145px;">

    </colgroup>


    {{-- =========================================================
         JUDUL
    ========================================================== --}}

    <tr>

        <th colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:20px;
                font-weight:bold;
                text-align:center;
                padding:10px;
            "
        >

            LAPORAN KEUANGAN

        </th>

    </tr>


    <tr>

        <th colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:15px;
                font-weight:bold;
                text-align:center;
                padding:5px;
            "
        >

            Nayla Bangunan

        </th>

    </tr>


    <tr>

        <td colspan="9"
            style="
                background-color:#ffffff;
                color:#666666;
                text-align:center;
                padding:6px;
            "
        >

            Ringkasan kinerja keuangan berdasarkan transaksi
            penjualan, retur, dan pencatatan kas.

        </td>

    </tr>


    {{-- =========================================================
         PERIODE
    ========================================================== --}}

    <tr>

        <td
            colspan="2"
            style="
                background-color:#f4f6fb;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:8px;
            "
        >

            Periode

        </td>


        <td
            colspan="7"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            @if($tanggalMulai && $tanggalAkhir)

                {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}

                &nbsp; - &nbsp;

                {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

            @elseif($tanggalMulai)

                Mulai
                {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }}

            @elseif($tanggalAkhir)

                Sampai
                {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

            @else

                Semua Tanggal

            @endif

        </td>

    </tr>


    <tr>
        <td colspan="9"></td>
    </tr>


    {{-- =========================================================
        RINGKASAN UTAMA
    ========================================================== --}}

    <tr>

        <td
            colspan="2"
            style="
                background-color:#eef4ff;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
            "
        >
            Total Penjualan
        </td>

        <td
            colspan="2"
            style="
                background-color:#eef4ff;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
                text-align:right;
            "
        >
            Rp {{ number_format(
                $totalPenjualan,
                0,
                ',',
                '.'
            ) }}
        </td>


        <td
            colspan="2"
            style="
                background-color:#fff0f0;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
            "
        >
            Total Retur
        </td>

        <td
            colspan="3"
            style="
                background-color:#fff0f0;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
                text-align:right;
            "
        >
            Rp {{ number_format(
                $totalRetur,
                0,
                ',',
                '.'
            ) }}
        </td>

    </tr>


    <tr>

        <td
            colspan="2"
            style="
                background-color:#eaf8ef;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
                color:#168a45;
            "
        >
            Kas Masuk
        </td>

        <td
            colspan="2"
            style="
                background-color:#eaf8ef;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
                color:#168a45;
                text-align:right;
            "
        >
            Rp {{ number_format(
                $totalKasMasuk,
                0,
                ',',
                '.'
            ) }}
        </td>


        <td
            colspan="2"
            style="
                background-color:#fff5e5;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
                color:#e33434;
            "
        >
            Kas Keluar
        </td>

        <td
            colspan="3"
            style="
                background-color:#fff5e5;
                border:1px solid #d9dee8;
                padding:10px;
                font-weight:bold;
                color:#e33434;
                text-align:right;
            "
        >
            Rp {{ number_format(
                $totalKasKeluar,
                0,
                ',',
                '.'
            ) }}
        </td>

    </tr>


    <tr>
        <td colspan="9"></td>
    </tr>


    {{-- =========================================================
         RINGKASAN KEUANGAN
    ========================================================== --}}

    <tr>

        <th
            colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:14px;
                font-weight:bold;
                text-align:left;
                padding:8px;
            "
        >

            Ringkasan Keuangan

        </th>

    </tr>


    {{-- PENJUALAN BRUTO --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Penjualan Bruto

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalPenjualanBruto,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- TOTAL DISKON --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Total Diskon

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                color:#e33434;
                text-align:right;
                padding:8px;
            "
        >

            - Rp {{ number_format(
                $totalDiskon,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- PENJUALAN BERSIH --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Penjualan Bersih

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                font-weight:bold;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalPenjualanBersih,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- HPP --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            HPP

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                text-align:right;
                padding:8px;
            "
        >

            - Rp {{ number_format(
                $totalHpp,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- LABA KOTOR --}}

    <tr>

        <td
            colspan="5"
            style="
                background-color:#eaf7ee;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:9px;
            "
        >

            Laba Kotor

        </td>

        <td
            colspan="4"
            style="
                background-color:#eaf7ee;
                border:1px solid #d9dee8;
                color:#168a45;
                font-weight:bold;
                text-align:right;
                padding:9px;
            "
        >

            Rp {{ number_format(
                $labaKotor,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    <tr>
        <td colspan="9"></td>
    </tr>


    {{-- =========================================================
         RINGKASAN RETUR
    ========================================================== --}}

    <tr>

        <th
            colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:14px;
                font-weight:bold;
                text-align:left;
                padding:8px;
            "
        >

            Ringkasan Retur

        </th>

    </tr>


    {{-- RETUR UANG --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Retur Uang

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalReturUang,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- TUKAR BARANG --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Tukar Barang

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalTukarBarang,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- NILAI PENGGANTI --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Nilai Barang Pengganti

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalNilaiPengganti,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    {{-- SELISIH PEMBAYARAN --}}

    <tr>

        <td
            colspan="5"
            style="
                border:1px solid #d9dee8;
                padding:8px;
            "
        >

            Selisih Pembayaran

        </td>

        <td
            colspan="4"
            style="
                border:1px solid #d9dee8;
                color:#168a45;
                font-weight:bold;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalSelisihPembayaran,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    <tr>
        <td colspan="9"></td>
    </tr>


    {{-- =========================================================
         ARUS KAS
    ========================================================== --}}

    <tr>

        <th
            colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:14px;
                font-weight:bold;
                text-align:left;
                padding:8px;
            "
        >

            Arus Kas

        </th>

    </tr>


    <tr>

        <td
            colspan="2"
            style="
                background-color:#eaf8ef;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:8px;
            "
        >

            Kas Masuk

        </td>

        <td
            colspan="2"
            style="
                border:1px solid #d9dee8;
                color:#168a45;
                font-weight:bold;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalKasMasuk,
                0,
                ',',
                '.'
            ) }}

        </td>


        <td
            colspan="2"
            style="
                background-color:#fff0f0;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:8px;
            "
        >

            Kas Keluar

        </td>

        <td
            colspan="2"
            style="
                border:1px solid #d9dee8;
                color:#e33434;
                font-weight:bold;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $totalKasKeluar,
                0,
                ',',
                '.'
            ) }}

        </td>

        <td></td>

    </tr>


    <tr>

        <td
            colspan="5"
            style="
                background-color:#eef4ff;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:8px;
            "
        >

            Arus Kas Bersih

        </td>

        <td
            colspan="4"
            style="
                background-color:#eef4ff;
                border:1px solid #d9dee8;
                color:#2864d7;
                font-weight:bold;
                text-align:right;
                padding:8px;
            "
        >

            Rp {{ number_format(
                $arusKasBersih,
                0,
                ',',
                '.'
            ) }}

        </td>

    </tr>


    <tr>
        <td colspan="9"></td>
    </tr>


    {{-- =========================================================
         DETAIL RETUR
    ========================================================== --}}

    <tr>

        <th
            colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:14px;
                font-weight:bold;
                text-align:left;
                padding:8px;
            "
        >

            Detail Retur

        </th>

    </tr>


    <tr>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            No
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Tanggal
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Kode Retur
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Kode Penjualan
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Kasir
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Jenis Retur
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            Total Retur
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            Nilai Pengganti
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            Selisih Pembayaran
        </th>

    </tr>


    @forelse($returns as $index => $return)

        <tr>

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:7px;
                "
            >
                {{ $index + 1 }}
            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:7px;
                "
            >

                {{ \Carbon\Carbon::parse(
                    $return->tanggal
                )->format('d/m/Y') }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    padding:7px;
                "
            >

                {{ $return->kode_retur }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    padding:7px;
                "
            >

                {{ $return->sale->kode_penjualan ?? '-' }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    padding:7px;
                "
            >

                {{ $return->user->name ?? '-' }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    padding:7px;
                "
            >

                @if($return->return_type === 'uang')

                    Retur Uang

                @elseif($return->return_type === 'tukar')

                    Tukar Barang

                @else

                    {{ $return->return_type ?? '-' }}

                @endif

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $return->total_retur ?? 0,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $return->total_pengganti ?? 0,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    color:#168a45;
                    font-weight:bold;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $return->selisih_bayar ?? 0,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    @empty

        <tr>

            <td
                colspan="9"
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:10px;
                "
            >

                Belum ada data retur.

            </td>

        </tr>

    @endforelse


    <tr>
        <td colspan="9"></td>
    </tr>


    {{-- =========================================================
         RINGKASAN PENJUALAN
    ========================================================== --}}

    <tr>

        <th
            colspan="9"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:14px;
                font-weight:bold;
                text-align:left;
                padding:8px;
            "
        >

            Ringkasan Penjualan

        </th>

    </tr>


    <tr>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            No
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Tanggal
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            No Penjualan
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:center;
                padding:7px;
            "
        >
            Kasir
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            Penjualan Bersih
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            Diskon
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            HPP
        </th>

        <th
            colspan="2"
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                text-align:right;
                padding:7px;
            "
        >
            Laba
        </th>

    </tr>


    @forelse($sales as $index => $sale)

        @php

            $hpp = $sale->saleDetails->sum(function ($detail) {

                return
                    $detail->qty *
                    ($detail->product->harga_beli ?? 0);

            });

            $laba =
                $sale->total_bayar -
                $hpp;

        @endphp


        <tr>

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:7px;
                "
            >

                {{ $index + 1 }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:7px;
                "
            >

                {{ \Carbon\Carbon::parse(
                    $sale->tanggal
                )->format('d/m/Y') }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    padding:7px;
                "
            >

                {{ $sale->kode_penjualan }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    padding:7px;
                "
            >

                {{ $sale->user->name ?? '-' }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $sale->total_bayar,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $sale->diskon ?? 0,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $hpp,
                    0,
                    ',',
                    '.'
                ) }}

            </td>


            <td
                colspan="2"
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    color:#168a45;
                    font-weight:bold;
                    padding:7px;
                "
            >

                Rp {{ number_format(
                    $laba,
                    0,
                    ',',
                    '.'
                ) }}

            </td>

        </tr>


    @empty

        <tr>

            <td
                colspan="9"
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:10px;
                "
            >

                Belum ada data penjualan.

            </td>

        </tr>

    @endforelse


    {{-- =========================================================
         INFORMASI CETAK
    ========================================================== --}}

    <tr>

        <td colspan="9"></td>

    </tr>


    <tr>

        <td
            colspan="2"
            style="
                font-weight:bold;
                color:#555555;
                padding:7px;
            "
        >

            Dicetak

        </td>

        <td
            colspan="7"
            style="
                color:#555555;
                padding:7px;
            "
        >

            {{ now()->format('d/m/Y H:i') }}

        </td>

    </tr>


</table>