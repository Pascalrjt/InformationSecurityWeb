@extends('master')
@section('content')

@php
    $cipher = "AES-256-CBC";
    $options = 0;
    $iv = str_repeat("0", openssl_cipher_iv_length($cipher));

    function rc4Decrypt($key, $encryptedStr) {
                    $encryptedStr = hex2bin($encryptedStr);
                    $s = array();
                    for ($i = 0; $i < 256; $i++) {
                        $s[$i] = $i;
                    }
                    $j = 0;
                    for ($i = 0; $i < 256; $i++) {
                        $j = ($j + $s[$i] + ord($key[$i % strlen($key)])) % 256;
                        $x = $s[$i];
                        $s[$i] = $s[$j];
                        $s[$j] = $x;
                    }
                    $i = 0;
                    $j = 0;
                    $res = '';
                    for ($y = 0; $y < strlen($encryptedStr); $y++) {
                        $i = ($i + 1) % 256;
                        $j = ($j + $s[$i]) % 256;
                        $x = $s[$i];
                        $s[$i] = $s[$j];
                        $s[$j] = $x;
                        $res .= $encryptedStr[$y] ^ chr($s[($s[$i] + $s[$j]) % 256]);
                    }
                    return $res;
                }

    $decryptedImageAES = openssl_decrypt(Auth::user()->imageBase64AES, $cipher, Auth::user()->keyAES, $options, $iv);
    $decryptedImageRC4 = rc4Decrypt(Auth::user()->keyRC4, Auth::user()->imageBase64RC4);
    $decryptedEmail = openssl_decrypt(Auth::user()->email, $cipher, Auth::user()->keyAES, $options, $iv);
    // $decryptedImageAES = openssl_decrypt(Auth::user()->image, $cipher, $secret);
@endphp


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
                <img src="data:image/png;base64,{{ $decryptedImageAES }}" alt="User Image" style="width: 30%; height: 30%; object-fit: cover;">
                <p>Size: {{ strlen(Auth::user()->imageBase64AES) }} bytes</p>
            </div>
            <div>
                <img src="data:image/png;base64,{{ $decryptedImageRC4 }}" alt="User Image RC4" style="width: 30%; height: 30%; object-fit: cover;">
                <p>Size: {{ strlen(Auth::user()->imageBase64RC4) }} bytes</p>
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
