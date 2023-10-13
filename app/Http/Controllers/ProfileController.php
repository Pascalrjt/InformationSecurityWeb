<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdoptionPlan;
use Illuminate\Support\Facades\Crypt;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        $cipher = "AES-128-ECB";
        $secret = "fadhlanganteng12";

        $username = Auth::user()->name;
        $username = openssl_decrypt($username, $cipher, $secret);
        $adoptionPlans = $user->adoptionplans;
        
        return view('profile', compact('adoptionPlans', 'username'));
    }

    public function show()
    {

    }
}
