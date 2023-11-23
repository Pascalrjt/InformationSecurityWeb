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

    public function update(Request $request, FileRequest $fileRequest)
    {
        $fileRequest->has_access = true;
        $fileRequest->save();

        // Fetch all files owned by the requested_id
        $files = Files::where('fileOwner', $fileRequest->requested_id)->get();

        // Duplicate each file and change the fileOwner to the requester_id
        foreach ($files as $file) {
            $newFile = $file->replicate();
            $newFile->fileOwner = $fileRequest->requester_id;
            $newFile->save();
        }

        $requester = User::find($fileRequest->requester_id);
        $notification = "User A has accepted your request.";

        return redirect('/inbox')->with('success', 'You have accepted the file request.');
    }

}
