@extends(Auth::user()->role === 'Admin' ? 'layouts.admin' : 'layouts.kasir')

@section('title', 'Ubah Password')

@section('content')

<style>

    .password-page {
        max-width: 100%;
    }

    .password-page-title {
        font-size: 32px;
        font-weight: 700;
        color: #24324a;
        margin-bottom: 6px;
    }

    .password-page-subtitle {
        font-size: 16px;
        color: #667085;
        margin-bottom: 25px;
    }

    .password-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.06);
        border: 1px solid #edf2f7;
        max-width: 750px;
    }

    .password-card-title {
        font-size: 20px;
        font-weight: 700;
        color: #24324a;
        margin-bottom: 8px;
    }

    .password-card-description {
        font-size: 14px;
        color: #667085;
        margin-bottom: 25px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #344054;
        margin-bottom: 8px;
    }

    .password-input-wrapper {
        position: relative;
    }

    .password-input {
        width: 100%;
        box-sizing: border-box;
        padding: 12px 45px 12px 14px;
        border: 1px solid #d0d5dd;
        border-radius: 10px;
        font-size: 14px;
        color: #1f2937;
        outline: none;
        transition: 0.2s;
    }

    .password-input:focus {
        border-color: #4e73df;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.12);
    }

    .password-toggle {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);

        border: none;
        background: transparent;

        color: #667085;

        cursor: pointer;

        padding: 0;

        font-size: 16px;
    }

    .password-toggle:hover {
        color: #355cc9;
    }

    .form-error {
        margin-top: 7px;
        font-size: 13px;
        color: #dc2626;
    }

    .success-message {
        background: #ecfdf3;
        border: 1px solid #abefc6;
        color: #067647;
        padding: 12px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .password-actions {
        margin-top: 25px;
        display: flex;
        justify-content: flex-end;
    }

    .btn-save-password {
        border: none;
        background: #4e73df;
        color: #ffffff;

        padding: 12px 22px;

        border-radius: 10px;

        font-size: 14px;
        font-weight: 600;

        cursor: pointer;

        transition: 0.2s;
    }

    .btn-save-password:hover {
        background: #355cc9;
    }

    @media(max-width: 768px) {

        .password-card {
            padding: 22px;
        }

        .password-page-title {
            font-size: 28px;
        }

        .password-actions {
            justify-content: stretch;
        }

        .btn-save-password {
            width: 100%;
        }

    }

</style>


<div class="password-page">

    {{-- HEADER --}}

    <h1 class="password-page-title">
        Ubah Password
    </h1>

    <p class="password-page-subtitle">
        Perbarui password akun Anda untuk menjaga keamanan akun.
    </p>


    {{-- CARD --}}

    <div class="password-card">

        <div class="password-card-title">
            Ubah Password
        </div>

        <div class="password-card-description">
            Masukkan password lama dan password baru Anda.
        </div>


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="success-message">
                <i class="fa-solid fa-circle-check"></i>
                {{ session('success') }}
            </div>

        @endif


        {{-- FORM --}}

        <form method="POST" action="{{ route('password.update') }}">

            @csrf

            {{-- PASSWORD LAMA --}}

            <div class="form-group">

                <label for="current_password">
                    Password Lama
                </label>

                <div class="password-input-wrapper">

                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        class="password-input"
                        placeholder="Masukkan password lama"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('current_password', this)"
                        aria-label="Tampilkan password"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </button>

                </div>

                @error('current_password')

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- PASSWORD BARU --}}

            <div class="form-group">

                <label for="password">
                    Password Baru
                </label>

                <div class="password-input-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="password-input"
                        placeholder="Masukkan password baru"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password', this)"
                        aria-label="Tampilkan password"
                    >
                        <i class="fa-solid fa-eye"></i>
                    </button>

                </div>

                @error('password')

                    <div class="form-error">
                        {{ $message }}
                    </div>

                @enderror

            </div>


            {{-- KONFIRMASI PASSWORD --}}

            <div class="form-group">

                <label for="password_confirmation">
                    Konfirmasi Password Baru
                </label>

                <div class="password-input-wrapper">

                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        class="password-input"
                        placeholder="Masukkan kembali password baru"
                        required
                    >

                    <button
                        type="button"
                        class="password-toggle"
                        onclick="togglePassword('password_confirmation', this)"
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


            {{-- BUTTON --}}

            <div class="password-actions">

                <button
                    type="submit"
                    class="btn-save-password"
                >

                    <i class="fa-solid fa-lock"></i>
                    Simpan Password

                </button>

            </div>

        </form>

    </div>

</div>


<script>

    function togglePassword(inputId, button) {

        const input = document.getElementById(inputId);

        const icon = button.querySelector('i');

        if (input.type === 'password') {

            input.type = 'text';

            icon.classList.remove('fa-eye');

            icon.classList.add('fa-eye-slash');

        } else {

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');

            icon.classList.add('fa-eye');

        }

    }

</script>

@endsection