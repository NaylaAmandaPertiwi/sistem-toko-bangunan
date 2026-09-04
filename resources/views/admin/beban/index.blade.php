@extends('layouts.admin')

@section('title', 'Pencatatan Beban')

@section('content')

<style>

    /* ==========================================================
       LAYOUT UTAMA
    ========================================================== */

    .page-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,.05);
    }

    .top-header {
        background: #1684e0;
        color: white;
        padding: 18px 25px;
        font-size: 28px;
        font-weight: 600;
    }

    .beban-page {
        padding: 25px;
    }

    .beban-breadcrumb span:last-child {
        color: #18233f;
        font-weight: 500;
    }


    /* ==========================================================
       ALERT
    ========================================================== */

    .beban-alert {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .beban-alert-success {
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        color: #047857;
    }

    .beban-alert-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
    }

    .beban-alert ul {
        margin: 5px 0 0 18px;
        padding: 0;
    }

    .alert-close {
        border: none;
        background: transparent;
        font-size: 20px;
        cursor: pointer;
        color: inherit;
    }


    /* ==========================================================
       SUMMARY CARD
    ========================================================== */

    .beban-summary {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .beban-summary-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 11px;
        padding: 21px 20px;
        box-shadow: 0 2px 8px rgba(20, 32, 56, 0.04);
    }

    .beban-summary-top {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .beban-summary-icon {
        width: 52px;
        height: 52px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .beban-summary-icon svg {
        width: 25px;
        height: 25px;
    }

    .icon-blue {
        background: #e5efff;
        color: #2670d9;
    }

    .icon-green {
        background: #e2f8ee;
        color: #16a66e;
    }

    .icon-purple {
        background: #e5efff;
        color: #2670d9;
    }

    .icon-orange {
        background: #fff2d5;
        color: #d88900;
    }

    .beban-summary-label {
        font-size: 14px;
        color: #25304a;
        margin-bottom: 8px;
    }

    .beban-summary-value {
        font-size: 22px;
        font-weight: 700;
        line-height: 1.2;
    }

    .value-blue {
        color: #1767d3;
    }

    .value-green {
        color: #13a66c;
    }

    .value-purple {
        color: #1767d3;
    }

    .value-orange {
        color: #d88900;
    }

    .beban-summary-period {
        margin-top: 14px;
        margin-left: 67px;
        font-size: 13px;
        color: #69748c;
    }


    /* ==========================================================
       MAIN CONTENT
    ========================================================== */

    .beban-main {
        display: grid;
        grid-template-columns: 360px minmax(0, 1fr);
        gap: 16px;
        align-items: stretch;
    }

    .beban-card {
        background: #fff;
        border: 1px solid #edf0f5;
        border-radius: 11px;
        box-shadow: 0 2px 8px rgba(20, 32, 56, 0.04);
        overflow: hidden;
    }

    .beban-card-header {
        padding: 20px 22px;
        border-bottom: 1px solid #edf0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .beban-card-title {
        display: flex;
        align-items: center;
        gap: 9px;
        font-size: 17px;
        font-weight: 700;
        color: #18233f;
    }

    .beban-card-title svg {
        width: 19px;
        height: 19px;
    }

    .beban-card-body {
        padding: 22px;
    }


    /* ==========================================================
       FORM
    ========================================================== */

    .beban-form-group {
        margin-bottom: 18px;
    }

    .beban-form-group label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #26314b;
    }

    .beban-input-wrapper {
        position: relative;
    }

    .beban-input,
    .beban-select,
    .beban-textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #d9dee8;
        border-radius: 6px;
        background: #fff;
        color: #1d2942;
        font-family: inherit;
        font-size: 13px;
        outline: none;
        transition: 0.2s;
    }

    .beban-input,
    .beban-select {
        height: 42px;
        padding: 0 12px;
    }

    .beban-textarea {
        min-height: 105px;
        padding: 12px;
        resize: vertical;
    }

    .beban-input:focus,
    .beban-select:focus,
    .beban-textarea:focus {
        border-color: #1684e0;
        box-shadow: 0 0 0 3px rgba(22, 132, 224, 0.08);
    }

    .beban-input.is-invalid,
    .beban-select.is-invalid,
    .beban-textarea.is-invalid {
        border-color: #dc2626;
    }

    .beban-input-group {
        display: flex;
        width: 100%;
    }

    .beban-currency {
        width: 48px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #d9dee8;
        border-right: none;
        border-radius: 6px 0 0 6px;
        background: #f7f8fa;
        color: #68738a;
        font-size: 13px;
    }

    .beban-rupiah-input {
        border-radius: 0 6px 6px 0;
    }

    .beban-field-error {
        margin-top: 5px;
        color: #dc2626;
        font-size: 12px;
    }

    .beban-form-actions {
        display: flex;
        gap: 10px;
        margin-top: 5px;
    }

    .beban-btn {
        height: 42px;
        border-radius: 6px;
        padding: 0 18px;
        border: none;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        transition: 0.2s;
    }

    .beban-btn svg {
        width: 16px;
        height: 16px;
    }

    .beban-btn-primary {
        background: #1684e0;
        color: #fff;
        box-shadow: 0 4px 10px rgba(22, 132, 224, 0.18);
    }

    .beban-btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 5px 13px rgba(22, 132, 224, 0.25);
    }

    .beban-btn-secondary {
        background: #fff;
        color: #536078;
        border: 1px solid #d9dee8;
    }

    .beban-btn-secondary:hover {
        background: #f8f9fb;
    }


    /* ==========================================================
       TABLE HEADER / FILTER BULAN & TAHUN
    ========================================================== */

    .beban-table-header {
        padding: 17px 20px;
        border-bottom: 1px solid #edf0f5;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .date-toolbar {
        position: relative;
    }

    .date-filter-btn {
        width: 230px;
        height: 42px;
        padding: 0 13px;
        border: 1px solid #d9dee8;
        border-radius: 8px;
        background: #fff;
        color: #26314b;
        font-family: inherit;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        transition: 0.2s;
    }

    .date-filter-btn:hover {
        border-color: #1684e0;
    }

    .date-filter-btn i:first-child {
        color: #1684e0;
    }

    .date-filter-dropdown {
        display: none;
        position: absolute;
        top: calc(100% + 6px);
        right: 0;
        width: 230px;
        background: #fff;
        border: 1px solid #e1e5eb;
        border-radius: 8px;
        box-shadow: 0 8px 25px rgba(15, 23, 42, 0.12);
        padding: 6px;
        z-index: 1000;
    }

    .date-filter-dropdown.show {
        display: block;
    }

    .date-option {
        width: 100%;
        padding: 10px 12px;
        border: none;
        border-radius: 6px;
        background: transparent;
        color: #26314b;
        text-align: left;
        font-family: inherit;
        font-size: 13px;
        cursor: pointer;
    }

    .date-option:hover {
        background: #eff6ff;
        color: #1684e0;
    }

    .date-option.active {
        background: #eaf3ff;
        color: #1684e0;
        font-weight: 600;
    }

    .date-filter-dropdown hr {
        border: none;
        border-top: 1px solid #edf0f5;
        margin: 5px 0;
    }

    /* ==========================================================
       TABLE
    ========================================================== */

    .beban-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .beban-table {
        width: 100%;
        min-width: 720px;
        border-collapse: collapse;
    }

    .beban-table th {
        background: #f8f9fb;
        padding: 13px 13px;
        border-bottom: 1px solid #e8ebf1;
        color: #27324b;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        white-space: nowrap;
    }

    .beban-table td {
        padding: 13px;
        border-bottom: 1px solid #edf0f4;
        color: #26314a;
        font-size: 12px;
        vertical-align: middle;
    }

    .beban-table tr:last-child td {
        border-bottom: none;
    }

    .beban-table th:first-child,
    .beban-table td:first-child {
        text-align: center;
        width: 50px;
    }

    .beban-table th:last-child,
    .beban-table td:last-child {
        text-align: center;
        width: 90px;
    }

    .beban-nominal {
        color: #dc2626 !important;
        font-weight: 600;
        white-space: nowrap;
    }

    .beban-type {
        display: inline-flex;
        align-items: center;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
        background: #eef2ff;
        color: #4f46e5;
    }

    .beban-type-listrik {
        background: #eaf2ff;
        color: #2468cf;
    }

    .beban-type-air {
        background: #e9f9f1;
        color: #13955f;
    }

    .beban-type-internet {
        background: #fff0f4;
        color: #d63f70;
    }

    .beban-type-gaji {
        background: #eaf3ff;
        color: #1767d3;
    }

    .beban-type-transportasi,
    .beban-type-pengiriman {
        background: #fff4dc;
        color: #c77b00;
    }

    .beban-type-perawatan {
        background: #eaf9fa;
        color: #078e96;
    }

    .beban-type-atk {
        background: #eaf3ff;
        color: #1767d3;
    }

    .beban-type-lainnya {
        background: #f1f3f5;
        color: #596273;
    }

    .beban-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        cursor: pointer;
        border: 1px solid;
        background: #fff;
        margin: 0 2px;
        transition: 0.2s;
    }

    .beban-action svg {
        width: 15px;
        height: 15px;
    }

    .beban-action-edit {
        color: #1264d8;
        border-color: #b9d5ff;
    }

    .beban-action-edit:hover {
        background: #eff6ff;
    }

    .beban-action-delete {
        color: #ef4444;
        border-color: #fecaca;
    }

    .beban-action-delete:hover {
        background: #fff1f2;
    }


    /* ==========================================================
       EMPTY
    ========================================================== */

    .beban-empty {
        text-align: center;
        padding: 45px 20px !important;
        color: #7b8497 !important;
    }

    .beban-empty svg {
        width: 42px;
        height: 42px;
        margin-bottom: 10px;
        color: #aab2c1;
    }


    /* ==========================================================
       PAGINATION
    ========================================================== */

    .beban-table-footer {
        padding: 14px 20px;
        border-top: 1px solid #edf0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
    }

    .beban-showing {
        font-size: 12px;
        color: #69748c;
    }

    .beban-pagination {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .beban-pagination a,
    .beban-pagination span {
        min-width: 36px;
        height: 36px;
        padding: 0 8px;
        border: 1px solid #e0e4eb;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        color: #33405a;
        background: #fff;
        font-size: 12px;
        box-sizing: border-box;
    }

    .beban-pagination .active {
        background: #1684e0;
        border-color: #1684e0;
        color: #fff;
    }

    .beban-pagination .disabled {
        color: #c0c5ce;
        background: #fafbfc;
    }


    /* ==========================================================
       MODAL EDIT
    ========================================================== */

    .beban-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 9999;
        background: rgba(15, 23, 42, 0.45);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .beban-modal.show {
        display: flex;
    }

    .beban-modal-content {
        width: 100%;
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2);
    }

    .beban-modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #edf0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .beban-modal-header h3 {
        margin: 0;
        font-size: 17px;
        color: #18233f;
    }

    .beban-modal-close {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        background: #f4f5f7;
        color: #647086;
        cursor: pointer;
        font-size: 20px;
    }

    .beban-modal-body {
        padding: 22px;
    }

    .beban-modal-footer {
        padding: 15px 22px;
        border-top: 1px solid #edf0f5;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .date-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        background: rgba(15, 23, 42, 0.45);
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .date-modal-overlay.show {
        display: flex;
    }

    .date-modal {
        width: 100%;
        max-width: 450px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 20px 50px rgba(15, 23, 42, 0.2);
        overflow: hidden;
    }

    .date-modal-header {
        padding: 18px 22px;
        border-bottom: 1px solid #edf0f5;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .date-modal-header h3 {
        margin: 0 0 5px;
        font-size: 17px;
        color: #18233f;
    }

    .date-modal-header p {
        margin: 0;
        font-size: 12px;
        color: #69748c;
    }

    .date-modal-close {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 6px;
        background: #f4f5f7;
        color: #647086;
        cursor: pointer;
        font-size: 20px;
    }

    .date-modal-body {
        padding: 22px;
    }

    .date-field {
        margin-bottom: 18px;
    }

    .date-field:last-child {
        margin-bottom: 0;
    }

    .date-field label {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        font-weight: 600;
        color: #26314b;
    }

    .date-input {
        width: 100%;
        height: 42px;
        box-sizing: border-box;
        padding: 0 12px;
        border: 1px solid #d9dee8;
        border-radius: 6px;
        background: #fff;
        color: #1d2942;
        font-family: inherit;
        font-size: 13px;
        outline: none;
    }

    .date-input:focus {
        border-color: #1684e0;
        box-shadow: 0 0 0 3px rgba(22, 132, 224, 0.08);
    }

    .date-error {
        margin-top: 10px;
        color: #dc2626;
        font-size: 12px;
    }

    .date-modal-footer {
        padding: 15px 22px;
        border-top: 1px solid #edf0f5;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .btn-cancel-modal,
    .btn-confirm {
        height: 40px;
        padding: 0 16px;
        border-radius: 6px;
        font-family: inherit;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-cancel-modal {
        border: 1px solid #d9dee8;
        background: #fff;
        color: #536078;
    }

    .btn-confirm {
        border: none;
        background: #1684e0;
        color: #fff;
    }


    /* ==========================================================
       RESPONSIVE
    ========================================================== */

    @media (max-width: 1200px) {

        .beban-summary {
            grid-template-columns: repeat(2, 1fr);
        }

        .beban-main {
            grid-template-columns: 330px minmax(0, 1fr);
        }
    }


    @media (max-width: 900px) {

        .beban-main {
            grid-template-columns: 1fr;
        }

        .beban-form-card {
            order: 1;
        }

        .beban-list-card {
            order: 2;
        }
    }


    @media (max-width: 650px) {

        .beban-page {
            padding: 20px 15px;
        }

        .beban-summary {
            grid-template-columns: 1fr;
        }

        .beban-table-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .date-toolbar {
            width: 100%;
        }

        .date-filter-btn {
            width: 100%;
        }
        
        .beban-table-footer {
            flex-direction: column;
            align-items: flex-start;
        }
    }

</style>


<div class="page-card">

    <div class="top-header">
        Beban Operasional
    </div>


    <div class="beban-page">

        {{-- =====================================================
             SUCCESS MESSAGE
        ====================================================== --}}

        @if(session('success'))

            <div class="beban-alert beban-alert-success">

                <div>
                    {{ session('success') }}
                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                >
                    ×
                </button>

            </div>

        @endif


        {{-- =====================================================
             VALIDATION ERROR
        ====================================================== --}}

        @if($errors->any())

            <div class="beban-alert beban-alert-error">

                <div>

                    <strong>Terjadi kesalahan.</strong>

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

                <button
                    type="button"
                    class="alert-close"
                    onclick="this.parentElement.remove()"
                >
                    ×
                </button>

            </div>

        @endif


        {{-- =====================================================
             SUMMARY
        ====================================================== --}}

        <div class="beban-summary">


            {{-- Total Beban Bulan yang Dipilih --}}
            <div class="beban-summary-card">

                <div class="beban-summary-top">

                    <div class="beban-summary-icon icon-blue">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M20 7h-9a2 2 0 0 1 0-4h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a4 4 0 0 1-4-4V7"/>
                            <path d="M2 7h16"/>
                            <circle cx="16" cy="14" r="1"/>
                        </svg>

                    </div>

                    <div>

                        <div class="beban-summary-label">
                            Total Beban
                        </div>

                        <div class="beban-summary-value value-blue">
                            Rp {{ number_format($totalBeban, 0, ',', '.') }}
                        </div>

                    </div>

                </div>

                <div class="beban-summary-period">

                    @switch($filter)

                        @case('today')
                            Hari Ini
                            @break

                        @case('yesterday')
                            Kemarin
                            @break

                        @case('week')
                            7 Hari Terakhir
                            @break

                        @case('month')
                            Bulan Ini
                            @break

                        @case('custom')

                            @if($tanggalAwal && $tanggalAkhir)

                                {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

                            @endif

                            @break

                        @default
                            Semua Data

                    @endswitch

                </div>

            </div>


            {{-- Total Beban Hari Ini --}}
            <div class="beban-summary-card">

                <div class="beban-summary-top">

                    <div class="beban-summary-icon icon-green">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 3v13"/>
                            <path d="m7 11 5 5 5-5"/>
                            <path d="M5 21h14"/>
                        </svg>

                    </div>

                    <div>

                        <div class="beban-summary-label">
                            Total Beban Hari Ini
                        </div>

                        <div class="beban-summary-value value-green">
                            Rp {{ number_format($totalBebanHariIni, 0, ',', '.') }}
                        </div>

                    </div>

                </div>

                <div class="beban-summary-period">
                    {{ now()->translatedFormat('d F Y') }}
                </div>

            </div>


            {{-- Jumlah Transaksi --}}
            <div class="beban-summary-card">

                <div class="beban-summary-top">

                    <div class="beban-summary-icon icon-purple">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <path d="M14 2v6h6"/>
                            <path d="M8 13h8"/>
                            <path d="M8 17h5"/>
                        </svg>

                    </div>

                    <div>

                        <div class="beban-summary-label">
                            Jumlah Transaksi
                        </div>

                        <div class="beban-summary-value value-purple">
                            {{ $jumlahTransaksi }}
                        </div>

                    </div>

                </div>

                <div class="beban-summary-period">

                    @switch($filter)

                        @case('today')
                            Hari Ini
                            @break

                        @case('yesterday')
                            Kemarin
                            @break

                        @case('week')
                            7 Hari Terakhir
                            @break

                        @case('month')
                            Bulan Ini
                            @break

                        @case('custom')

                            @if($tanggalAwal && $tanggalAkhir)

                                {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

                            @endif

                            @break

                        @default
                            Semua Data

                    @endswitch

                </div>

            </div>


            {{-- Rata-rata Beban --}}
            <div class="beban-summary-card">

                <div class="beban-summary-top">

                    <div class="beban-summary-icon icon-orange">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <rect x="3" y="4" width="18" height="17" rx="2"/>
                            <path d="M16 2v4"/>
                            <path d="M8 2v4"/>
                            <path d="M3 10h18"/>
                            <path d="M8 14h.01"/>
                            <path d="M12 14h.01"/>
                            <path d="M16 14h.01"/>
                            <path d="M8 18h.01"/>
                            <path d="M12 18h.01"/>
                        </svg>

                    </div>

                    <div>

                        <div class="beban-summary-label">
                            Rata-rata Beban /Hari
                        </div>

                        <div class="beban-summary-value value-orange">
                            Rp {{ number_format($rataRataBebanPerHari, 0, ',', '.') }}
                        </div>

                    </div>

                </div>

                <div class="beban-summary-period">

                    @switch($filter)

                        @case('today')
                            Hari Ini
                            @break

                        @case('yesterday')
                            Kemarin
                            @break

                        @case('week')
                            7 Hari Terakhir
                            @break

                        @case('month')
                            Bulan Ini
                            @break

                        @case('custom')

                            @if($tanggalAwal && $tanggalAkhir)

                                {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }}
                                -
                                {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

                            @endif

                            @break

                        @default
                            Semua Data

                    @endswitch

                </div>

            </div>

        </div>


        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}

        <div class="beban-main">


            {{-- =================================================
                 FORM TAMBAH
            ================================================== --}}

            <div class="beban-card beban-form-card">

                <div class="beban-card-header">

                    <div class="beban-card-title">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M12 5v14"/>
                            <path d="M5 12h14"/>
                            <rect x="3" y="3" width="18" height="18" rx="3"/>
                        </svg>

                        Tambah Pencatatan Beban

                    </div>

                </div>


                <div class="beban-card-body">

                    <form
                        action="{{ route('admin.beban-operasional.store') }}"
                        method="POST"
                    >

                        @csrf


                        {{-- Tanggal --}}
                        <div class="beban-form-group">

                            <label for="tanggal">
                                Tanggal
                            </label>

                            <input
                                type="date"
                                id="tanggal"
                                name="tanggal"
                                class="beban-input @error('tanggal') is-invalid @enderror"
                                value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                            >

                            @error('tanggal')

                                <div class="beban-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Jenis Beban --}}
                        <div class="beban-form-group">

                            <label for="jenis_beban">
                                Jenis Beban
                            </label>

                            <select
                                id="jenis_beban"
                                name="jenis_beban"
                                class="beban-select @error('jenis_beban') is-invalid @enderror"
                            >

                                <option value="">
                                    -- Pilih Jenis Beban --
                                </option>

                                @foreach($jenisBeban as $jenis)

                                    <option
                                        value="{{ $jenis }}"
                                        {{ old('jenis_beban') === $jenis ? 'selected' : '' }}
                                    >
                                        {{ $jenis }}
                                    </option>

                                @endforeach

                            </select>

                            @error('jenis_beban')

                                <div class="beban-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Nominal --}}
                        <div class="beban-form-group">

                            <label for="nominal_display">
                                Nominal
                            </label>

                            <div class="beban-input-group">

                                <div class="beban-currency">
                                    Rp
                                </div>

                                <input
                                    type="text"
                                    id="nominal_display"
                                    class="beban-input beban-rupiah-input @error('nominal') is-invalid @enderror"
                                    placeholder="0"
                                    autocomplete="off"
                                    inputmode="numeric"
                                    value="{{ old('nominal') ? number_format((float) old('nominal'), 0, ',', '.') : '' }}"
                                >

                            </div>

                            <input
                                type="hidden"
                                id="nominal"
                                name="nominal"
                                value="{{ old('nominal') }}"
                            >

                            @error('nominal')

                                <div class="beban-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Keterangan --}}
                        <div class="beban-form-group">

                            <label for="keterangan">
                                Keterangan
                            </label>

                            <textarea
                                id="keterangan"
                                name="keterangan"
                                class="beban-textarea @error('keterangan') is-invalid @enderror"
                                placeholder="Masukkan keterangan (opsional)"
                            >{{ old('keterangan') }}</textarea>

                            @error('keterangan')

                                <div class="beban-field-error">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        {{-- Button --}}
                        <div class="beban-form-actions">

                            <button
                                type="submit"
                                class="beban-btn beban-btn-primary"
                            >

                                <svg
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="2"
                                >
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                                    <path d="M17 21v-8H7v8"/>
                                    <path d="M7 3v5h8"/>
                                </svg>

                                Simpan

                            </button>


                            <button
                                type="reset"
                                class="beban-btn beban-btn-secondary"
                                onclick="resetTambahForm()"
                            >
                                Reset
                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- =================================================
                 DAFTAR BEBAN
            ================================================== --}}

            <div class="beban-card beban-list-card">

                <div class="beban-table-header">


                    {{-- Judul --}}
                    <div class="beban-card-title">

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path d="M4 4h16v16H4z"/>
                            <path d="M8 8h8"/>
                            <path d="M8 12h8"/>
                            <path d="M8 16h5"/>
                        </svg>

                        Daftar Pencatatan Beban

                    </div>


                    {{-- =================================================
                         FILTER BULAN & TAHUN
                    ================================================== --}}

                    <div class="date-toolbar">

                        <button
                            type="button"
                            class="date-filter-btn"
                            id="dateFilterButton"
                        >

                            <i class="fa-regular fa-calendar"></i>

                            <span id="selectedFilterText">

                                @switch($filter)

                                    @case('today')
                                        Hari Ini
                                        @break

                                    @case('yesterday')
                                        Kemarin
                                        @break

                                    @case('week')
                                        7 Hari Terakhir
                                        @break

                                    @case('month')
                                        Bulan Ini
                                        @break

                                    @case('custom')

                                        @if($tanggalAwal && $tanggalAkhir)

                                            {{ \Carbon\Carbon::parse($tanggalAwal)->format('d/m/Y') }}
                                            -
                                            {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}

                                        @else

                                            Pilih Tanggal...

                                        @endif

                                        @break

                                    @default
                                        Semua Tanggal

                                @endswitch

                            </span>

                            <i class="fa-solid fa-chevron-down"></i>

                        </button>


                        <div
                            class="date-filter-dropdown"
                            id="dateFilterDropdown"
                        >

                            <button
                                type="button"
                                class="date-option {{ $filter === 'all' ? 'active' : '' }}"
                                data-filter="all"
                            >
                                Semua Tanggal
                            </button>

                            <button
                                type="button"
                                class="date-option {{ $filter === 'today' ? 'active' : '' }}"
                                data-filter="today"
                            >
                                Hari Ini
                            </button>

                            <button
                                type="button"
                                class="date-option {{ $filter === 'yesterday' ? 'active' : '' }}"
                                data-filter="yesterday"
                            >
                                Kemarin
                            </button>

                            <button
                                type="button"
                                class="date-option {{ $filter === 'week' ? 'active' : '' }}"
                                data-filter="week"
                            >
                                7 Hari Terakhir
                            </button>

                            <button
                                type="button"
                                class="date-option {{ $filter === 'month' ? 'active' : '' }}"
                                data-filter="month"
                            >
                                Bulan Ini
                            </button>

                            <hr>

                            <button
                                type="button"
                                class="date-option"
                                id="customDate"
                            >
                                Pilih Tanggal...
                            </button>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     TABLE
                ================================================== --}}

                <div class="beban-table-wrapper">

                    <table class="beban-table">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis Beban</th>
                                <th>Keterangan</th>
                                <th>Nominal</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($bebans as $index => $beban)

                                @php

                                    $typeClass = match($beban->jenis_beban) {

                                        'Listrik' =>
                                            'beban-type-listrik',

                                        'Air' =>
                                            'beban-type-air',

                                        'Internet' =>
                                            'beban-type-internet',

                                        'Gaji/Upah' =>
                                            'beban-type-gaji',

                                        'Transportasi' =>
                                            'beban-type-transportasi',

                                        'Pengiriman' =>
                                            'beban-type-pengiriman',

                                        'Perawatan' =>
                                            'beban-type-perawatan',

                                        'ATK' =>
                                            'beban-type-atk',

                                        default =>
                                            'beban-type-lainnya',

                                    };

                                @endphp


                                <tr>


                                    {{-- No --}}
                                    <td>
                                        {{ $bebans->firstItem() + $index }}
                                    </td>


                                    {{-- Tanggal --}}
                                    <td>
                                        {{ $beban->tanggal->format('d/m/Y') }}
                                    </td>


                                    {{-- Jenis Beban --}}
                                    <td>

                                        <span class="beban-type {{ $typeClass }}">
                                            {{ $beban->jenis_beban }}
                                        </span>

                                    </td>


                                    {{-- Keterangan --}}
                                    <td>
                                        {{ $beban->keterangan ?: '-' }}
                                    </td>


                                    {{-- Nominal --}}
                                    <td class="beban-nominal">
                                        Rp {{ number_format($beban->nominal, 0, ',', '.') }}
                                    </td>


                                    {{-- Aksi --}}
                                    <td>


                                        {{-- Edit --}}
                                        <button
                                            type="button"
                                            class="beban-action beban-action-edit"
                                            title="Edit"
                                            onclick="openEditModal(
                                                {{ $beban->id }},
                                                '{{ $beban->tanggal->format('Y-m-d') }}',
                                                @js($beban->jenis_beban),
                                                '{{ $beban->nominal }}',
                                                @js($beban->keterangan)
                                            )"
                                        >

                                            <svg
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                            >
                                                <path d="M12 20h9"/>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
                                            </svg>

                                        </button>


                                        {{-- Hapus --}}
                                        <form
                                            action="{{ route('admin.beban-operasional.destroy', $beban->id) }}"
                                            method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus pencatatan beban ini?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="beban-action beban-action-delete"
                                                title="Hapus"
                                            >

                                                <svg
                                                    viewBox="0 0 24 24"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    stroke-width="2"
                                                >
                                                    <polyline points="3 6 5 6 21 6"/>
                                                    <path d="M19 6l-1 14H6L5 6"/>
                                                    <path d="M10 11v6"/>
                                                    <path d="M14 11v6"/>
                                                    <path d="M9 6V4h6v2"/>
                                                </svg>

                                            </button>

                                        </form>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="6"
                                        class="beban-empty"
                                    >

                                        <svg
                                            viewBox="0 0 24 24"
                                            fill="none"
                                            stroke="currentColor"
                                            stroke-width="1.5"
                                        >
                                            <rect
                                                x="4"
                                                y="3"
                                                width="16"
                                                height="18"
                                                rx="2"
                                            />

                                            <path d="M8 8h8"/>
                                            <path d="M8 12h8"/>
                                            <path d="M8 16h5"/>

                                        </svg>


                                        <div>

                                            Belum ada pencatatan beban pada periode yang dipilih.

                                        </div>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                     PAGINATION
                ================================================== --}}

                @if($bebans->total() > 0)

                    <div class="beban-table-footer">


                        <div class="beban-showing">

                            Menampilkan
                            {{ $bebans->firstItem() }}
                            -
                            {{ $bebans->lastItem() }}
                            dari
                            {{ $bebans->total() }}
                            data

                        </div>


                        <div class="beban-pagination">


                            {{-- Previous --}}
                            @if($bebans->onFirstPage())

                                <span class="disabled">
                                    ‹
                                </span>

                            @else

                                <a href="{{ $bebans->previousPageUrl() }}">
                                    ‹
                                </a>

                            @endif


                            {{-- Number --}}
                            @foreach(
                                $bebans->getUrlRange(
                                    1,
                                    $bebans->lastPage()
                                )
                                as $page => $url
                            )

                                @if($page == $bebans->currentPage())

                                    <span class="active">
                                        {{ $page }}
                                    </span>

                                @else

                                    <a href="{{ $url }}">
                                        {{ $page }}
                                    </a>

                                @endif

                            @endforeach


                            {{-- Next --}}
                            @if($bebans->hasMorePages())

                                <a href="{{ $bebans->nextPageUrl() }}">
                                    ›
                                </a>

                            @else

                                <span class="disabled">
                                    ›
                                </span>

                            @endif

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

{{-- =========================================================
     MODAL PILIH RENTANG TANGGAL
========================================================= --}}

<div
    id="dateModal"
    class="date-modal-overlay"
>

    <div class="date-modal">

        <div class="date-modal-header">

            <div>

                <h3>
                    Pilih Rentang Tanggal
                </h3>

                <p>
                    Tentukan tanggal awal dan tanggal akhir.
                </p>

            </div>

            <button
                type="button"
                class="date-modal-close"
                id="closeDateModal"
            >
                ×
            </button>

        </div>


        <div class="date-modal-body">

            <div class="date-field">

                <label for="tanggalAwal">
                    Tanggal Awal
                </label>

                <input
                    type="date"
                    id="tanggalAwal"
                    class="date-input"
                    value="{{ $tanggalAwal }}"
                >

            </div>


            <div class="date-field">

                <label for="tanggalAkhir">
                    Tanggal Akhir
                </label>

                <input
                    type="date"
                    id="tanggalAkhir"
                    class="date-input"
                    value="{{ $tanggalAkhir }}"
                >

            </div>


            <div
                id="dateError"
                class="date-error"
                style="display:none;"
            ></div>

        </div>


        <div class="date-modal-footer">

            <button
                type="button"
                class="btn-cancel-modal"
                id="cancelDateModal"
            >
                Batal
            </button>

            <button
                type="button"
                class="btn-confirm"
                id="confirmDateFilter"
            >
                Terapkan
            </button>

        </div>

    </div>

</div>

{{-- =========================================================
     MODAL EDIT BEBAN
========================================================= --}}

<div
    id="editBebanModal"
    class="beban-modal"
>

    <div class="beban-modal-content">


        <div class="beban-modal-header">

            <h3>
                Edit Pencatatan Beban
            </h3>

            <button
                type="button"
                class="beban-modal-close"
                onclick="closeEditModal()"
            >
                ×
            </button>

        </div>


        <form
            id="editBebanForm"
            method="POST"
        >

            @csrf
            @method('PUT')

            <input
                type="hidden"
                name="edit_id"
                id="edit_id"
            >


            <div class="beban-modal-body">


                {{-- Tanggal --}}
                <div class="beban-form-group">

                    <label for="edit_tanggal">
                        Tanggal
                    </label>

                    <input
                        type="date"
                        id="edit_tanggal"
                        name="tanggal"
                        class="beban-input"
                        required
                    >

                </div>


                {{-- Jenis --}}
                <div class="beban-form-group">

                    <label for="edit_jenis_beban">
                        Jenis Beban
                    </label>

                    <select
                        id="edit_jenis_beban"
                        name="jenis_beban"
                        class="beban-select"
                        required
                    >

                        <option value="">
                            -- Pilih Jenis Beban --
                        </option>

                        @foreach($jenisBeban as $jenis)

                            <option value="{{ $jenis }}">
                                {{ $jenis }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Nominal --}}
                <div class="beban-form-group">

                    <label for="edit_nominal_display">
                        Nominal
                    </label>

                    <div class="beban-input-group">

                        <div class="beban-currency">
                            Rp
                        </div>

                        <input
                            type="text"
                            id="edit_nominal_display"
                            class="beban-input beban-rupiah-input"
                            inputmode="numeric"
                            autocomplete="off"
                            required
                        >

                    </div>

                    <input
                        type="hidden"
                        id="edit_nominal"
                        name="nominal"
                    >

                </div>


                {{-- Keterangan --}}
                <div class="beban-form-group">

                    <label for="edit_keterangan">
                        Keterangan
                    </label>

                    <textarea
                        id="edit_keterangan"
                        name="keterangan"
                        class="beban-textarea"
                        placeholder="Masukkan keterangan (opsional)"
                    ></textarea>

                </div>

            </div>


            <div class="beban-modal-footer">

                <button
                    type="button"
                    class="beban-btn beban-btn-secondary"
                    onclick="closeEditModal()"
                >
                    Batal
                </button>

                <button
                    type="submit"
                    class="beban-btn beban-btn-primary"
                >
                    Simpan Perubahan
                </button>

            </div>

        </form>

    </div>

</div>


<script>

    /* ==========================================================
       FORMAT RUPIAH
    ========================================================== */

    function formatRupiah(angka) {

        angka = String(angka).replace(/\D/g, '');

        if (!angka) {
            return '';
        }

        return angka.replace(
            /\B(?=(\d{3})+(?!\d))/g,
            '.'
        );
    }


    function angkaMurni(angka) {

        return String(angka).replace(
            /\D/g,
            ''
        );

    }


    /* ==========================================================
       FORM TAMBAH
    ========================================================== */

    const nominalDisplay =
        document.getElementById('nominal_display');

    const nominalHidden =
        document.getElementById('nominal');


    if (nominalDisplay) {

        nominalDisplay.addEventListener(
            'input',
            function () {

                const value =
                    angkaMurni(this.value);

                this.value =
                    formatRupiah(value);

                nominalHidden.value =
                    value;

            }
        );

    }


    /* ==========================================================
       RESET FORM TAMBAH
    ========================================================== */

    function resetTambahForm() {

        setTimeout(function () {

            const display =
                document.getElementById(
                    'nominal_display'
                );

            const hidden =
                document.getElementById(
                    'nominal'
                );


            if (display) {
                display.value = '';
            }


            if (hidden) {
                hidden.value = '';
            }


            const tanggal =
                document.getElementById(
                    'tanggal'
                );


            if (tanggal) {

                tanggal.value =
                    '{{ now()->format('Y-m-d') }}';

            }

        }, 0);

    }


    /* ==========================================================
       MODAL EDIT
    ========================================================== */

    const editModal =
        document.getElementById(
            'editBebanModal'
        );


    function openEditModal(
        id,
        tanggal,
        jenisBeban,
        nominal,
        keterangan
    ) {

        const form =
            document.getElementById(
                'editBebanForm'
            );


        form.action =
            "{{ url('/admin/beban-operasional') }}/" +
            id;


        document.getElementById(
            'edit_id'
        ).value = id;


        document.getElementById(
            'edit_tanggal'
        ).value = tanggal;


        document.getElementById(
            'edit_jenis_beban'
        ).value = jenisBeban;


        const nominalValue =
            angkaMurni(nominal);


        document.getElementById(
            'edit_nominal'
        ).value = nominalValue;


        document.getElementById(
            'edit_nominal_display'
        ).value =
            formatRupiah(nominalValue);


        document.getElementById(
            'edit_keterangan'
        ).value =
            keterangan || '';


        editModal.classList.add(
            'show'
        );


        document.body.style.overflow =
            'hidden';

    }


    function closeEditModal() {

        editModal.classList.remove(
            'show'
        );

        document.body.style.overflow =
            '';

    }


    /* ==========================================================
       FORMAT NOMINAL EDIT
    ========================================================== */

    const editNominalDisplay =
        document.getElementById(
            'edit_nominal_display'
        );


    const editNominalHidden =
        document.getElementById(
            'edit_nominal'
        );


    if (editNominalDisplay) {

        editNominalDisplay.addEventListener(
            'input',
            function () {

                const value =
                    angkaMurni(this.value);


                this.value =
                    formatRupiah(value);


                editNominalHidden.value =
                    value;

            }
        );

    }


    /* ==========================================================
       KLIK DI LUAR MODAL EDIT
    ========================================================== */

    editModal.addEventListener(
        'click',
        function (event) {

            if (
                event.target === editModal
            ) {

                closeEditModal();

            }

        }
    );


    /* ==========================================================
       ESC UNTUK MODAL EDIT
    ========================================================== */

    document.addEventListener(
        'keydown',
        function (event) {

            if (
                event.key === 'Escape'
            ) {

                closeEditModal();

            }

        }
    );


    /* ==========================================================
       AUTO OPEN EDIT MODAL JIKA UPDATE GAGAL
    ========================================================== */

    @if(
        $errors->any() &&
        old('_method') === 'PUT' &&
        old('edit_id')
    )

        openEditModal(
            {{ old('edit_id') }},
            @js(old('tanggal')),
            @js(old('jenis_beban')),
            @js(old('nominal')),
            @js(old('keterangan'))
        );

    @endif

    /* ==========================================================
    FILTER TANGGAL
    LANGSUNG DITERAPKAN
    ========================================================== */

    const dateFilterButton =
        document.getElementById(
            'dateFilterButton'
        );

    const dateFilterDropdown =
        document.getElementById(
            'dateFilterDropdown'
        );

    const customDate =
        document.getElementById(
            'customDate'
        );

    const dateModal =
        document.getElementById(
            'dateModal'
        );

    const closeDateModal =
        document.getElementById(
            'closeDateModal'
        );

    const cancelDateModal =
        document.getElementById(
            'cancelDateModal'
        );

    const confirmDateFilter =
        document.getElementById(
            'confirmDateFilter'
        );

    const tanggalAwal =
        document.getElementById(
            'tanggalAwal'
        );

    const tanggalAkhir =
        document.getElementById(
            'tanggalAkhir'
        );

    const dateError =
        document.getElementById(
            'dateError'
        );


    /*
    |--------------------------------------------------------------------------
    | Buka Dropdown
    |--------------------------------------------------------------------------
    */

    if (dateFilterButton) {

        dateFilterButton.addEventListener(
            'click',
            function (event) {

                event.stopPropagation();

                dateFilterDropdown.classList.toggle(
                    'show'
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Tutup Dropdown
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                dateFilterDropdown &&
                dateFilterButton &&
                !dateFilterDropdown.contains(event.target) &&
                !dateFilterButton.contains(event.target)
            ) {

                dateFilterDropdown.classList.remove(
                    'show'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Filter Preset
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        '.date-option[data-filter]'
    ).forEach(function (button) {

        button.addEventListener(
            'click',
            function () {

                const filter =
                    this.dataset.filter;

                const url =
                    new URL(
                        window.location.href
                    );

                url.searchParams.set(
                    'filter',
                    filter
                );

                url.searchParams.delete(
                    'tanggal_awal'
                );

                url.searchParams.delete(
                    'tanggal_akhir'
                );

                url.searchParams.delete(
                    'page'
                );

                window.location.href =
                    url.toString();

            }
        );

    });


    /*
    |--------------------------------------------------------------------------
    | Buka Modal Pilih Tanggal
    |--------------------------------------------------------------------------
    */

    if (customDate) {

        customDate.addEventListener(
            'click',
            function () {

                dateFilterDropdown.classList.remove(
                    'show'
                );

                dateModal.classList.add(
                    'show'
                );

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Tutup Modal
    |--------------------------------------------------------------------------
    */

    function closeDateModalFunction() {

        dateModal.classList.remove(
            'show'
        );

        dateError.style.display =
            'none';

    }


    if (closeDateModal) {

        closeDateModal.addEventListener(
            'click',
            closeDateModalFunction
        );

    }


    if (cancelDateModal) {

        cancelDateModal.addEventListener(
            'click',
            closeDateModalFunction
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Terapkan Rentang Tanggal
    |--------------------------------------------------------------------------
    */

    if (confirmDateFilter) {

        confirmDateFilter.addEventListener(
            'click',
            function () {

                const awal =
                    tanggalAwal.value;

                const akhir =
                    tanggalAkhir.value;


                if (!awal || !akhir) {

                    dateError.textContent =
                        'Tanggal awal dan tanggal akhir wajib dipilih.';

                    dateError.style.display =
                        'block';

                    return;

                }


                if (awal > akhir) {

                    dateError.textContent =
                        'Tanggal akhir harus sama atau setelah tanggal awal.';

                    dateError.style.display =
                        'block';

                    return;

                }


                const url =
                    new URL(
                        window.location.href
                    );


                url.searchParams.set(
                    'filter',
                    'custom'
                );

                url.searchParams.set(
                    'tanggal_awal',
                    awal
                );

                url.searchParams.set(
                    'tanggal_akhir',
                    akhir
                );

                url.searchParams.delete(
                    'page'
                );


                window.location.href =
                    url.toString();

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | Klik Area Luar Modal
    |--------------------------------------------------------------------------
    */

    if (dateModal) {

        dateModal.addEventListener(
            'click',
            function (event) {

                if (
                    event.target === dateModal
                ) {

                    closeDateModalFunction();

                }

            }
        );

    }

</script>

@endsection