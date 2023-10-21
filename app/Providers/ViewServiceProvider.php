<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cipher = "AES-256-CBC";
                $options = 0;
                $iv = str_repeat("0", openssl_cipher_iv_length($cipher));

                $username = Auth::user()->name;
                $username = openssl_decrypt($username, $cipher, Auth::user()->keyAES, $options, $iv);
                // $username = openssl_decrypt($username, $cipher, $secret);
                $view->with('username', $username);
            }
        });
    }
}
