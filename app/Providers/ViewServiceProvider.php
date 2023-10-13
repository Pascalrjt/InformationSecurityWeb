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
                $cipher = "AES-128-ECB";
                $secret = "fadhlanganteng12";

                $username = Auth::user()->name;
                $username = openssl_decrypt($username, $cipher, $secret);
                $view->with('username', $username);
            }
        });
    }
}