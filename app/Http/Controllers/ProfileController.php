<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AdoptionPlan;

class ProfileController extends Controller
{
    public function index(){
        $user = Auth::user();
        $adoptionPlans = $user->adoptionplans;

        return view('profile', compact('adoptionPlans'));
    }

    public function show()
    {

    }
}
