@extends('master')
@section('content')

@if(Auth::check())
    <style>
    .centered-alert {
        position: absolute;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 20px; /* Adjust this value to your liking */
        z-index: 9999;
    }

    .alert {
        text-align: center;
        width: 25%; /* Adjust this value to your liking */
        margin: 0 auto;
    }
    </style>

    <h1>User List</h1>
        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show small-font" role="alert">
            {{ session('success') }} <br>
            </div>
        @endif

    <div class="row mx-5 justify-content-center">
        @foreach ($users->where('id', '!=', Auth::id()) as $user)
            <div class="card mx-2 bg-dark text-white user-card" style="width: 400px; height: 400px;">
                    <div class="text-center" style="width: 100%; height: 300px; margin: 10px 0; position: relative;">
                        <?php
                            $cipher = "AES-256-CBC";
                            $options = 0;
                            $iv = str_repeat("0", openssl_cipher_iv_length($cipher));
                            $encryptionKey = $user->keyAES;
                            $decryptedName = openssl_decrypt($user->name, $cipher, $encryptionKey, $options, $iv);
                            $decryptedImageAES = openssl_decrypt($user->imageBase64AES, $cipher, $encryptionKey, $options, $iv);
                        ?>
                        <img src="data:image/png;base64,{{ $decryptedImageAES }}" alt="User Image" style="width: 100%; height: 100%; object-fit: cover;">
                        <h5 class="mb-0 user-name">{{$decryptedName}}</h5>
                        <form method="POST" action="{{ route('filerequest.store') }}">
                            @csrf
                            <input type="hidden" name="requested_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-primary mt-2">Request Files</button>
                        </form>
                    </div>
            </div>
        @endforeach
    </div>
@else
    <p>You need to be logged in to view this page. Please <a href="/login">login</a>.</p>
@endif

@endsection
