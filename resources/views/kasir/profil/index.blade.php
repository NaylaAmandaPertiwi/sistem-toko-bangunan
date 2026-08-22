@extends('layouts.kasir')

@section('title', 'Profil Saya')

@section('styles')

<style>

.profile-page{
    max-width:100%;
}

.profile-page-title{
    font-size:32px;
    font-weight:700;
    color:#24324a;
    margin-bottom:6px;
}

.profile-page-subtitle{
    font-size:16px;
    color:#667085;
    margin-bottom:25px;
}

/* PROFILE CARD */

.profile-card{
    background:#ffffff;
    border-radius:22px;
    overflow:hidden;
    box-shadow:0 12px 30px rgba(0,0,0,.06);
    border:1px solid #edf2f7;
}

/* PROFILE HEADER */

.profile-card-header{
    background:linear-gradient(
        135deg,
        #4e73df,
        #355cc9
    );

    padding:30px;

    display:flex;
    align-items:center;

    gap:20px;

    color:#ffffff;
}

.profile-avatar{
    width:82px;
    height:82px;

    border-radius:50%;

    background:rgba(255,255,255,.18);

    display:flex;
    align-items:center;
    justify-content:center;

    font-size:40px;

    flex-shrink:0;
}

.profile-header-info h2{
    margin:0;

    font-size:28px;
    font-weight:700;
}

.profile-header-info p{
    margin-top:5px;

    font-size:15px;

    opacity:.95;
}

/* BODY */

.profile-card-body{
    padding:30px;
}

.profile-section-title{
    font-size:20px;
    font-weight:700;
    color:#24324a;

    margin-bottom:20px;
}

/* INFORMATION GRID */

.profile-info-grid{
    display:grid;

    grid-template-columns:
        repeat(2,1fr);

    gap:20px;
}

.profile-info-item{
    background:#f8fafc;

    border:1px solid #edf2f7;

    border-radius:14px;

    padding:18px;
}

.profile-info-label{
    font-size:14px;

    color:#667085;

    margin-bottom:7px;
}

.profile-info-value{
    font-size:16px;

    font-weight:600;

    color:#1f2937;
}

.profile-role{
    display:inline-block;

    padding:6px 14px;

    border-radius:999px;

    background:#edf4ff;

    color:#355cc9;

    font-size:13px;

    font-weight:600;
}

/* RESPONSIVE */

@media(max-width:768px){

    .profile-info-grid{
        grid-template-columns:1fr;
    }

    .profile-card-header{
        padding:25px;
    }

    .profile-header-info h2{
        font-size:24px;
    }

}

</style>

@endsection


@section('content')

<div class="profile-page">

    {{-- HEADER --}}

    <h1 class="profile-page-title">
        Profil Saya
    </h1>

    <p class="profile-page-subtitle">
        Informasi akun pengguna yang sedang login.
    </p>


    {{-- PROFILE CARD --}}

    <div class="profile-card">

        {{-- PROFILE HEADER --}}

        <div class="profile-card-header">

            <div class="profile-avatar">

                <i class="fa-solid fa-user"></i>

            </div>

            <div class="profile-header-info">

                <h2>
                    {{ Auth::user()->name }}
                </h2>

                @if(Auth::user()->role === 'Admin')

                    <p>
                        {{ Auth::user()->email }}
                    </p>

                @else

                    <p>
                        {{ Auth::user()->username }}
                    </p>

                @endif

            </div>

        </div>


        {{-- PROFILE BODY --}}

        <div class="profile-card-body">

            <div class="profile-section-title">
                Informasi Akun
            </div>


            <div class="profile-info-grid">

                {{-- NAMA --}}

                <div class="profile-info-item">

                    <div class="profile-info-label">
                        Nama
                    </div>

                    <div class="profile-info-value">
                        {{ Auth::user()->name }}
                    </div>

                </div>


                {{-- IDENTITAS LOGIN --}}

                <div class="profile-info-item">

                    <div class="profile-info-label">

                        @if(Auth::user()->role === 'Admin')
                            Email
                        @else
                            Username
                        @endif

                    </div>

                    <div class="profile-info-value">

                        @if(Auth::user()->role === 'Admin')

                            {{ Auth::user()->email }}

                        @else

                            {{ Auth::user()->username }}

                        @endif

                    </div>

                </div>


                {{-- ROLE --}}

                <div class="profile-info-item">

                    <div class="profile-info-label">
                        Role
                    </div>

                    <div>

                        <span class="profile-role">

                            {{ Auth::user()->role }}

                        </span>

                    </div>

                </div>


                {{-- TERDAFTAR --}}

                <div class="profile-info-item">

                    <div class="profile-info-label">
                        Terdaftar Sejak
                    </div>

                    <div class="profile-info-value">

                        {{ Auth::user()->created_at->format('d/m/Y') }}

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection