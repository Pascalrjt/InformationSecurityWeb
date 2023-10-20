@extends('master')
@section('content')

@php
    $cipher = "AES-128-ECB";
    $secret = "fadhlanganteng12";
    $decryptedImage = openssl_decrypt(Auth::user()->image, $cipher, $secret);
@endphp
<!-- <img src="data:image/png;base64,{{ $decryptedImage }}" alt="User Image"  style="width: 100%; height: 100%; object-fit: cover;"> -->

<style>
    .profile {
        padding-right: 40px
    }
</style>

    <div class="container">
        <h1>{{ $username }}</h1>
        <p>{{ Auth::user()->email }}</p>
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
