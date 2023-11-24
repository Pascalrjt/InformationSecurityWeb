<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FileRequest;
use App\Models\Files;

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

    // public function update(Request $request, FileRequest $fileRequest)
    // {
    //     $fileRequest->has_access = true;
    //     $fileRequest->save();

    //     // Fetch all files owned by the requested_id
    //     $files = Files::where('fileOwner', $fileRequest->requested_id)->get();

    //     // Duplicate each file and change the fileOwner to the requester_id
    //     foreach ($files as $file) {
    //         $newFile = $file->replicate();
    //         $newFile->fileOwner = $fileRequest->requester_id;
    //         $newFile->isDuplicate = true;
    //         $newFile->save();
    //     }

    //     $requester = User::find($fileRequest->requester_id);
    //     $notification = "User A has accepted your request.";

    //     return redirect('/inbox')->with('success', 'You have accepted the file request.');
    // }

    public function update(Request $request, FileRequest $fileRequest)
    {
        $fileRequest->has_access = true;
        $fileRequest->save();

        // Fetch all files owned by the requested_id
        $files = Files::where('fileOwner', $fileRequest->requested_id)->get();

        // Define the cipher
        $cipher = "AES-256-CBC";
        $options = 0;

        // Generating a new secret
        $newAESkey = bin2hex(openssl_random_pseudo_bytes(16));
        // $AESkeykey = bin2hex(openssl_random_pseudo_bytes(16));
        $AESkeykey = env('AES_KEY_KEY');

        // Duplicate each file and change the fileOwner to the requester_id
        foreach ($files as $file) {
            $newFile = $file->replicate();
            $newFile->fileOwner = $fileRequest->requester_id;
            $newFile->isDuplicate = true;

            // Fetch the iv from the file
            $iv = $file->iv;
            // Decrypting the FileBase64
            $decryptedFileBase64 = openssl_decrypt($file->file_base64, $cipher, $file->secret, $options, $iv);
            // Re-encrypting the file with the new secret
            $encryptedFileBase64 = openssl_encrypt($decryptedFileBase64, $cipher,  $newAESkey, $options, $iv);

            $encrypedAESkey = openssl_encrypt($newAESkey, $cipher, $AESkeykey, $options, $iv);
            $AESkeyMessage = openssl_encrypt($encrypedAESkey, $cipher, $AESkeykey, $options, $iv);

            // Storing the encrpyted file and the new secret
            $newFile->file_base64 = $encryptedFileBase64;

            // secret is holding the value of the encrypted key [Temporarily] [WIP]
            $newFile->secret = $AESkeyMessage;

            // This will be the final assigned value for secret
            // $newFile->secret = null;


            $newFile->save();
        }

        $requester = User::find($fileRequest->requester_id);
        $notification = "User A has accepted your request.";

        return redirect('/inbox')->with('success', 'You have accepted the file request.');
    }
}
