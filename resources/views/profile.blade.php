@extends('master')
@section('content')

@php
    $cipher = "AES-256-CBC";
    $options = 0;
    $iv = str_repeat("0", openssl_cipher_iv_length($cipher));
    $decryptedImage = openssl_decrypt(Auth::user()->image, $cipher, Auth::user()->key, $options, $iv);
    $decryptedEmail = openssl_decrypt(Auth::user()->email, $cipher, Auth::user()->key, $options, $iv);
    // $decryptedImage = openssl_decrypt(Auth::user()->image, $cipher, $secret);
@endphp
<!-- <img src="data:image/png;base64,{{ $decryptedImage }}" alt="User Image"  style="width: 100%; height: 100%; object-fit: cover;"> -->

<style>
    .profile {
        padding-right: 40px
    }
</style>

    <div class="container">
        <h1>{{ $username }}</h1>
        <p>{{ $decryptedEmail }}</p>
        <p>{{ Auth::user()->bio }}</p>
        <div>
            <h2>ID Image</h2>
            <div>
                <!-- <img src="data:image/png;base64,{{ Auth::user()->image }}" alt="User Image"  style="width: 100%; height: 100%; object-fit: cover;"> -->
                {{-- <img src="data:image/png;base64,{{ $decryptedImage }}" alt="User Image"  style="width: 100%; height: 100%; object-fit: cover;"> --}}
                <img src="data:image/png;base64,{{ $decryptedImage }}" alt="User Image" style="width: 30%; height: 30%; object-fit: cover;">
            </div>
        </div>
        <div class="profile">
            <ul>
                @foreach ($adoptionPlans as $adoptionPlan)
                    <h5>Animal Name: {{ $adoptionPlan->animal->name }}</h5>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
