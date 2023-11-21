<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FileRequest;

class FileRequestController extends Controller
{
    public function store(Request $request, User $requested)
    {
        $user = Auth::user(); // Get the currently logged-in user

        $filerequest = FileRequest::create([
            'requested_id' => $requested->id,
            'requester_id' => $user->id,
            'has_access' => false,

        ]);
        return redirect('/users')->with('success', 'Successfuly requested files!');
    }

    // public function store(Request $request, Animals $animals)
    // {
    //     $user = Auth::user(); // Get the currently logged-in user

    //     $adoptionPlan = AdoptionPlan::create([
    //         'animal_id' => $animals->id,
    //         'user_id' => $user->id,
    //         'adopter_name' => $user->name,
    //         'adopter_email' => $user->email,
    //     ]);

    //     return redirect()->back()->with('success', 'Adoption plan created successfully.');
    // }
}
