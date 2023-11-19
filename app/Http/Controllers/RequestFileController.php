<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files; // Add this line

class RequestFileController extends Controller
{
    public function store(Request $request, Files $files) // Change the second parameter to Files
    {
        $user = Auth::user(); // Get the currently logged-in user

        $file = $files->find($request->file_id); // Find the file by its ID


        $requestFile = RequestFile::create([
            'requested_id' => $file->id,
            'requester_id' => $user->id,
        ]);

        return redirect()->back()->with('success', 'File request created successfully.');
    }
}
