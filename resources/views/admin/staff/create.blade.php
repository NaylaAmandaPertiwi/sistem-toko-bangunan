@extends('layouts.admin')

@section('title', 'Tambah Kasir')

@section('content')

<style>

/* =========================
   PAGE
========================= */

.staff-create-page{
    width:100%;
}


/* =========================
   CARD UTAMA
========================= */

.staff-create-card{

    background:#ffffff;

    border-radius:16px;

    overflow:hidden;

    box-shadow:
        0 2px 10px
        rgba(0,0,0,.05);
}


/* =========================
   HEADER BIRU
========================= */

.staff-create-header{

    background:#1684e0;

    color:white;

    padding:18px 25px;

    font-size:28px;

    font-weight:600;
}


/* =========================
   FORM CONTAINER
========================= */

.staff-create-body{

    padding:25px;
}


/* =========================
   SUBTITLE
========================= */

.staff-create-description{

    color:#667085;

    font-size:14px;

    margin-bottom:25px;

    line-height:1.6;
}


/* =========================
   FORM GROUP
========================= */

.form-group{

    margin-bottom:20px;
}


/* =========================
   LABEL
========================= */

.form-group label{

    display:block;

    margin-bottom:8px;

    color:#344054;

    font-size:14px;

    font-weight:600;
}


/* =========================
   INPUT
========================= */

.form-input{

    width:100%;

    box-sizing:border-box;

    padding:12px 14px;

    border:1px solid #d0d5dd;

    border-radius:10px;

    font-size:14px;

    color:#1f2937;

    outline:none;

    transition:.2s;
}


.form-input:focus{

    border-color:#4e73df;

    box-shadow:
        0 0 0 3px
        rgba(78,115,223,.12);
}


/* =========================
   PASSWORD WRAPPER
========================= */

.password-wrapper{

    position:relative;
}


.password-wrapper .form-input{

    padding-right:45px;
}


/* =========================
   TOGGLE PASSWORD
========================= */

.password-toggle{

    position:absolute;

    right:14px;

    top:50%;

    transform:translateY(-50%);

    border:none;

    background:transparent;

    color:#667085;

    cursor:pointer;

    padding:0;

    font-size:16px;
}


.password-toggle:hover{

    color:#355cc9;
}


/* =========================
   ERROR
========================= */

.form-error{

    margin-top:7px;

    color:#dc2626;

    font-size:13px;
}


/* =========================
   INFO PASSWORD
========================= */

.password-info{

    margin-top:7px;

    color:#667085;

    font-size:12px;
}


/* =========================
   BUTTON AREA
========================= */

.form-actions{

    display:flex;

    justify-content:flex-end;

    gap:10px;

    margin-top:30px;

    padding-top:20px;

    border-top:1px solid #eaecf0;
}


/* =========================
   BUTTON KEMBALI
========================= */

.btn-back{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    padding:11px 18px;

    border-radius:10px;

    background:#f2f4f7;

    color:#344054;

    text-decoration:none;

    font-size:14px;

    font-weight:600;

    transition:.2s;
}


.btn-back:hover{

    background:#e4e7ec;
}


/* =========================
   BUTTON SIMPAN
========================= */

.btn-save{

    display:inline-flex;

    align-items:center;

    justify-content:center;

    gap:8px;

    padding:11px 18px;

    border:none;

    border-radius:10px;

    background:#4CAF50;

    color:#ffffff;

    font-size:14px;

    font-weight:600;

    cursor:pointer;

    transition:.2s;
}


.btn-save:hover{

    background:#43a047;
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .staff-create-body{

        padding:20px;
    }

    .staff-create-header{

        font-size:24px;
    }

    .form-actions{

        flex-direction:column;
    }

    .btn-back,
    .btn-save{

        width:100%;
    }

}

</style>


<div class="staff-create-page">


    {{-- =========================
         CARD UTAMA
    ========================== --}}

    <div class="staff-create-card">


        {{-- =========================
             HEADER
        ========================== --}}

        <div class="staff-create-header">

            Tambah Kasir

        </div>


        {{-- =========================
             BODY FORM
        ========================== --}}

        <div class="staff-create-body">


            <div class="staff-create-description">

                Buat akun baru untuk Kasir agar dapat
                mengakses sistem sesuai dengan hak aksesnya.

            </div>


            {{-- =========================
                 FORM
            ========================== --}}

            <form
                method="POST"
                action="{{ route('admin.staff.store') }}"
            >

                @csrf


                {{-- =========================
                     NAMA
                ========================== --}}

                <div class="form-group">

                    <label for="name">

                        Nama Kasir

                    </label>


                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-input"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama kasir"
                        autocomplete="name"
                        required
                    >


                    @error('name')

                        <div class="form-error">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =========================
                     USERNAME
                ========================== --}}

                <div class="form-group">

                    <label for="username">

                        Username

                    </label>


                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-input"
                        value="{{ old('username') }}"
                        placeholder="Masukkan username kasir"
                        autocomplete="username"
                        required
                    >


                    @error('username')

                        <div class="form-error">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =========================
                     PASSWORD
                ========================== --}}

                <div class="form-group">

                    <label for="password">

                        Password

                    </label>


                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan password kasir"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'password',
                                this
                            )"
                            aria-label="Tampilkan password"
                        >

                            <i class="fa-solid fa-eye"></i>

                        </button>

                    </div>


                    <div class="password-info">

                        Password minimal 8 karakter.

                    </div>


                    @error('password')

                        <div class="form-error">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =========================
                     KONFIRMASI PASSWORD
                ========================== --}}

                <div class="form-group">

                    <label for="password_confirmation">

                        Konfirmasi Password

                    </label>


                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Masukkan kembali password"
                            autocomplete="new-password"
                            required
                        >


                        <button
                            type="button"
                            class="password-toggle"
                            onclick="togglePassword(
                                'password_confirmation',
                                this
                            )"
                            aria-label="Tampilkan password"
                        >

                            <i class="fa-solid fa-eye"></i>

                        </button>

                    </div>


                    @error('password_confirmation')

                        <div class="form-error">

                            {{ $message }}

                        </div>

                    @enderror

                </div>


                {{-- =========================
                     ACTION
                ========================== --}}

                <div class="form-actions">


                    <a
                        href="{{ route('admin.staff.index') }}"
                        class="btn-back"
                    >

                        <i class="fa-solid fa-arrow-left"></i>

                        Kembali

                    </a>


                    <button
                        type="submit"
                        class="btn-save"
                    >

                        <i class="fa-solid fa-user-plus"></i>

                        Simpan Kasir

                    </button>


                </div>


            </form>

        </div>

    </div>

</div>


@endsection


@section('scripts')

<script>

function togglePassword(inputId, button) {

    const input =
        document.getElementById(inputId);

    const icon =
        button.querySelector('i');


    if (input.type === 'password') {

        input.type = 'text';

        icon.classList.remove(
            'fa-eye'
        );

        icon.classList.add(
            'fa-eye-slash'
        );

    } else {

        input.type = 'password';

        icon.classList.remove(
            'fa-eye-slash'
        );

        icon.classList.add(
            'fa-eye'
        );

    }

}

</script>

@endsection