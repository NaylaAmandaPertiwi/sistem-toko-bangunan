<table>

    <colgroup>

        <col style="width: 55px;">

        <col style="width: 105px;">

        <col style="width: 190px;">

        <col style="width: 85px;">

        <col style="width: 125px;">

        <col style="width: 115px;">

        <col style="width: 125px;">

        <col style="width: 125px;">

    </colgroup>

    {{-- =========================================================
         JUDUL
    ========================================================== --}}

    <tr>
        <th colspan="8"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:20px;
                font-weight:bold;
                text-align:center;
                padding:8px;
            ">
            LAPORAN KEUANGAN
        </th>
    </tr>

    <tr>
        <th colspan="8"
            style="
                background-color:#ffffff;
                color:#222222;
                font-size:15px;
                font-weight:bold;
                text-align:center;
                padding:5px;
            ">
            Nayla Bangunan
        </th>
    </tr>


    {{-- =========================================================
         FILTER PERIODE
    ========================================================== --}}

    <tr>

        <td
            style="
                width:120px;
                background-color:#f4f6fb;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:6px;
            "
        >
            Tanggal Mulai
        </td>

        <td
            style="
                width:120px;
                border:1px solid #d9dee8;
                padding:6px;
            "
        >
            {{ $tanggalMulai ?: 'Semua' }}
        </td>

        <td colspan="6"></td>

    </tr>


    <tr>

        <td
            style="
                background-color:#f4f6fb;
                border:1px solid #d9dee8;
                font-weight:bold;
                padding:6px;
            "
        >
            Tanggal Akhir
        </td>

        <td
            style="
                border:1px solid #d9dee8;
                padding:6px;
            "
        >
            {{ $tanggalAkhir ?: 'Semua' }}
        </td>

        <td colspan="6"></td>

    </tr>


    {{-- =========================================================
         SPASI
    ========================================================== --}}

    <tr>
        <td colspan="8"></td>
    </tr>


    {{-- =========================================================
        RINGKASAN
    ========================================================= --}}

    <tr>

        <td
            style="
                font-weight:bold;
                background-color:#f4f6fb;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Total Penjualan
        </td>

        <td
            colspan="7"
            style="
                font-weight:bold;
                text-align:right;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Rp {{ number_format($totalPenjualan, 0, ',', '.') }}
        </td>

    </tr>


    <tr>

        <td
            style="
                font-weight:bold;
                background-color:#f4f6fb;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Total Diskon
        </td>

        <td
            colspan="7"
            style="
                font-weight:bold;
                text-align:right;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Rp {{ number_format($totalDiskon, 0, ',', '.') }}
        </td>

    </tr>


    <tr>

        <td
            style="
                font-weight:bold;
                background-color:#f4f6fb;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Total HPP
        </td>

        <td
            colspan="7"
            style="
                font-weight:bold;
                text-align:right;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Rp {{ number_format($totalHpp, 0, ',', '.') }}
        </td>

    </tr>


    <tr>

        <td
            style="
                font-weight:bold;
                background-color:#eaf7ee;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Laba Kotor
        </td>

        <td
            colspan="7"
            style="
                font-weight:bold;
                text-align:right;
                color:#168a45;
                background-color:#eaf7ee;
                border:1px solid #d9dee8;
                padding:8px;
            "
        >
            Rp {{ number_format($labaKotor, 0, ',', '.') }}
        </td>

    </tr>


    {{-- =========================================================
         SPASI
    ========================================================== --}}

    <tr>
        <td colspan="8"></td>
    </tr>


    {{-- =========================================================
         HEADER TABEL
    ========================================================== --}}

    <tr>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            No
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            Tanggal
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            Kode Penjualan
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            Kasir
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            Penjualan
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            Diskon
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            HPP
        </th>

        <th
            style="
                background-color:#355cc9;
                color:#ffffff;
                border:1px solid #294aa5;
                font-weight:bold;
                text-align:center;
                padding:8px;
            "
        >
            Laba Kotor
        </th>

    </tr>


    {{-- =========================================================
         DATA PENJUALAN
    ========================================================== --}}

    @forelse($sales as $index => $sale)

        @php

            $hpp = 0;

            foreach ($sale->saleDetails as $detail) {

                $hargaBeli =
                    $detail->product->harga_beli ?? 0;

                $hpp +=
                    $detail->qty * $hargaBeli;

            }

            $laba =
                $sale->total_bayar - $hpp;

        @endphp


        <tr>

            {{-- NO --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:7px;
                "
            >
                {{ $index + 1 }}
            </td>


            {{-- TANGGAL --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:center;
                    padding:7px;
                "
            >
                {{ \Carbon\Carbon::parse($sale->tanggal)->format('d/m/Y') }}
            </td>


            {{-- KODE PENJUALAN --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:left;
                    padding:7px;
                "
            >
                {{ $sale->kode_penjualan }}
            </td>


            {{-- KASIR --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:left;
                    padding:7px;
                "
            >
                {{ $sale->user->name ?? '-' }}
            </td>


            {{-- PENJUALAN --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >
                Rp {{ number_format($sale->total_bayar, 0, ',', '.') }}
            </td>


            {{-- DISKON --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >
                Rp {{ number_format($sale->diskon, 0, ',', '.') }}
            </td>


            {{-- HPP --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    padding:7px;
                "
            >
                Rp {{ number_format($hpp, 0, ',', '.') }}
            </td>


            {{-- LABA KOTOR --}}

            <td
                style="
                    border:1px solid #d9dee8;
                    text-align:right;
                    font-weight:bold;
                    padding:7px;
                "
            >
                Rp {{ number_format($laba, 0, ',', '.') }}
            </td>

        </tr>


    @empty

        <tr>

            <td
                colspan="8"
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
         CETAK
    ========================================================== --}}

    <tr>
        <td colspan="8"></td>
    </tr>

    <tr>

        <td
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