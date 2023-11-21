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
    $user = Auth::user();

    $existingRequest = FileRequest::where('requested_id', $request->input('requested_id'))
        ->where('requester_id', $user->id)
        ->first();

    if (!$existingRequest) {
        $filerequest = FileRequest::create([
            'requested_id' => $request->input('requested_id'),
            'requester_id' => $user->id,
            'has_access' => false,
        ]);

        return redirect('/users')->with('success', 'Successfully requested files!');
    } else {
        return redirect('/users')->with('error', 'File request already exists!');
    }
}

}
