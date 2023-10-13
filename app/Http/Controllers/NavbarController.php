<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class NavbarController extends Controller
{

    public function index(){
    $cipher = "AES-128-ECB";
    $secret = "fadhlanganteng12";

    $username = Auth::user()->name;
    $username = openssl_decrypt($username, $cipher, $secret);

    return view('navbar', compact('username'));
    }
}
