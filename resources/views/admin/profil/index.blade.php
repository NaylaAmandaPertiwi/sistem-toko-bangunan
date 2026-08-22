@extends('layouts.admin')

@section('title', 'Profil Saya')

@section('content')

<style>

    .profile-page {
        width: 100%;
    }

    .profile-header {
        margin-bottom: 25px;
    }

    .profile-header h2 {
        margin: 0 0 7px 0;
        font-size: 28px;
        font-weight: 700;
        color: #183153;
    }

    .profile-header p {
        margin: 0;
        font-size: 14px;
        color: #6b7a90;
    }

    .profile-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    .profile-card-header {
        padding: 25px;
        background: linear-gradient(
            135deg,
            #4e73df,
            #355cc9
        );

        color: white;

        display: flex;
        align-items: center;
        gap: 18px;
    }

    .profile-avatar {
        width: 75px;
        height: 75px;

        border-radius: 50%;

        background: rgba(255,255,255,0.18);

        display: flex;
        align-items: center;
        justify-content: center;

        font-size: 38px;

        flex-shrink: 0;
    }

    .profile-card-header h3 {
        margin: 0 0 5px 0;
        font-size: 21px;
        font-weight: 700;
    }

    .profile-card-header p {
        margin: 0;
        font-size: 13px;
        opacity: 0.9;
    }

    .profile-body {
        padding: 25px;
    }

    .profile-section-title {
        margin: 0 0 18px 0;

        font-size: 17px;
        font-weight: 700;

        color: #183153;
    }

    .profile-info-grid {
        display: grid;

        grid-template-columns:
            repeat(2, minmax(0, 1fr));

        gap: 18px;
    }

    .profile-info {
        background: #f8fafc;

        border: 1px solid #edf1f7;

        border-radius: 12px;

        padding: 16px;
    }

    .profile-info-label {
        display: block;

        margin-bottom: 7px;

        font-size: 12px;

        color: #6b7280;

        font-weight: 600;
    }

    .profile-info-value {
        font-size: 15px;

        color: #1f2937;

        font-weight: 600;

        word-break: break-word;
    }

    .role-badge {
        display: inline-flex;

        align-items: center;

        padding: 5px 12px;

        border-radius: 20px;

        background: #e8f0ff;

        color: #355cc9;

        font-size: 12px;

        font-weight: 700;
    }

    @media (max-width: 700px) {

        .profile-info-grid {
            grid-template-columns: 1fr;
        }

        .profile-card-header {
            padding: 20px;
        }

        .profile-body {
            padding: 20px;
        }

    }

</style>


<div class="profile-page">


    {{-- =====================================================
         HEADER
    ====================================================== --}}

    <div class="profile-header">

        <h2>
            Profil Saya
        </h2>

        <p>
            Informasi akun pengguna yang sedang login.
        </p>

    </div>


    {{-- =====================================================
         PROFILE CARD
    ====================================================== --}}

    <div class="profile-card">


        {{-- HEADER PROFILE --}}

        <div class="profile-card-header">

            <div class="profile-avatar">

                <i class="fa-solid fa-user"></i>

            </div>


            <div>

                <h3>
                    {{ $user->name }}
                </h3>

                <p>
                    {{ $user->email }}
                </p>

            </div>

        </div>


        {{-- BODY PROFILE --}}

        <div class="profile-body">

            <h3 class="profile-section-title">
                Informasi Akun
            </h3>


            <div class="profile-info-grid">


                {{-- NAMA --}}

                <div class="profile-info">

                    <span class="profile-info-label">
                        Nama
                    </span>

                    <div class="profile-info-value">
                        {{ $user->name }}
                    </div>

                </div>


                {{-- EMAIL --}}

                <div class="profile-info">

                    <span class="profile-info-label">
                        Email
                    </span>

                    <div class="profile-info-value">
                        {{ $user->email }}
                    </div>

                </div>


                {{-- ROLE --}}

                <div class="profile-info">

                    <span class="profile-info-label">
                        Role
                    </span>

                    <div class="profile-info-value">

                        <span class="role-badge">

                            {{ $user->role }}

                        </span>

                    </div>

                </div>


                {{-- BERGABUNG --}}

                <div class="profile-info">

                    <span class="profile-info-label">
                        Terdaftar Sejak
                    </span>

                    <div class="profile-info-value">

                        {{ $user->created_at
                            ? $user->created_at->format('d/m/Y')
                            : '-'
                        }}

                    </div>

                </div>


            </div>

        </div>

    </div>

</div>

@endsection