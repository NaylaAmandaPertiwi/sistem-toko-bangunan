@extends('layouts.admin')

@section('title', 'Reset Password Kasir')

@section('content')

<style>

/* =========================
   PAGE
========================= */

.staff-reset-page{
    width:100%;
}


/* =========================
   CARD UTAMA
========================= */

.staff-reset-card{

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

.staff-reset-header{

    background:#1684e0;

    color:white;

    padding:18px 25px;

    font-size:28px;

    font-weight:600;
}


/* =========================
   BODY
========================= */

.staff-reset-body{

    padding:25px;
}


/* =========================
   DESKRIPSI
========================= */

.staff-reset-description{

    color:#667085;

    font-size:14px;

    margin-bottom:25px;

    line-height:1.6;
}


/* =========================
   INFO KASIR
========================= */

.staff-reset-user{

    background:#f8f9fc;

    border:1px solid #eaecf0;

    border-radius:10px;

    padding:15px 18px;

    margin-bottom:25px;
}


.staff-reset-user-label{

    color:#667085;

    font-size:12px;

    margin-bottom:5px;
}


.staff-reset-user-name{

    color:#24324a;

    font-size:16px;

    font-weight:700;
}


.staff-reset-user-username{

    color:#667085;

    font-size:13px;

    margin-top:3px;
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
   PASSWORD
========================= */

.password-wrapper{

    position:relative;
}


.password-wrapper .form-input{

    padding-right:45px;
}


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
   INFO PASSWORD
========================= */

.password-info{

    margin-top:7px;

    color:#667085;

    font-size:12px;
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
   ACTION
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
   BUTTON RESET
========================= */

.btn-reset{

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


.btn-reset:hover{

    background:#43a047;
}


/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){

    .staff-reset-body{

        padding:20px;
    }

    .staff-reset-header{

        font-size:24px;
    }

    .form-actions{

        flex-direction:column;
    }

    .btn-back,
    .btn-reset{

        width:100%;
    }

}

</style>


<div class="staff-reset-page">

    <div class="staff-reset-card">


        {{-- =========================
             HEADER
        ========================== --}}

        <div class="staff-reset-header">

            Reset Password Kasir

        </div>


        {{-- =========================
             BODY
        ========================== --}}

        <div class="staff-reset-body">


            <div class="staff-reset-description">

                Buat password baru untuk akun Kasir.
                Password lama tidak dapat dilihat dan tidak perlu diketahui
                oleh Admin.

            </div>


            {{-- =========================
                 INFORMASI KASIR
            ========================== --}}

            <div class="staff-reset-user">

                <div class="staff-reset-user-label">

                    Akun Kasir

                </div>


                <div class="staff-reset-user-name">

                    {{ $staff->name }}

                </div>


                <div class="staff-reset-user-username">

                    Username: {{ $staff->username }}

                </div>

            </div>


            {{-- =========================
                 FORM
            ========================== --}}

            <form
                method="POST"
                action="{{ route(
                    'admin.staff.reset-password.update',
                    $staff->id
                ) }}"
            >

                @csrf


                {{-- =========================
                     PASSWORD BARU
                ========================== --}}

                <div class="form-group">

                    <label for="password">

                        Password Baru

                    </label>


                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-input"
                            placeholder="Masukkan password baru"
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

                        Konfirmasi Password Baru

                    </label>


                    <div class="password-wrapper">

                        <input
                            type="password"
                            id="password_confirmation"
                            name="password_confirmation"
                            class="form-input"
                            placeholder="Masukkan kembali password baru"
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
                        class="btn-reset"
                    >

                        <i class="fa-solid fa-key"></i>

                        Simpan Password Baru

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

        button.setAttribute(
            'aria-label',
            'Sembunyikan password'
        );

    } else {

        input.type = 'password';

        icon.classList.remove(
            'fa-eye-slash'
        );

        icon.classList.add(
            'fa-eye'
        );

        button.setAttribute(
            'aria-label',
            'Tampilkan password'
        );

    }

}

</script>

@endsection