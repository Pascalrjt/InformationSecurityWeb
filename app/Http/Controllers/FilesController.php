<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Files;
use Exception;

class filesController extends Controller {


    public function index()
    {
        $files = Files::all();

        return view('files.index', [
            'files' => $files,
            'title' => 'files'
        ]);
    }

    function upload() {
        return view("files.create");
    }

    public function store(Request $request) {
        $request->validate([
            'file' => 'required|file|mimes:jpg,jpeg,png,heic,pdf,mp4',
        ]);

        $fileUpload = $request->file('file');

        if ($fileUpload) {
            $fileBase64 = base64_encode(file_get_contents($fileUpload));
        } else {
            $fileBase64 = null;
        }

        $fileName = $fileUpload->getClientOriginalName();
        $fileNameParts = explode('.', $fileName);
        $fileExtension = end($fileNameParts);
        $userId = $request->user()->id;

        // Ciphers
        $cipher = "AES-256-CBC";

        // Key
        function generateAESKey(){
            return bin2hex(openssl_random_pseudo_bytes(16));
        }

        $aeskey = generateAESKey();
        // $secret = "12345678901234567890123456789012";

        //Iv
        $options = 0;
        $iv = str_repeat("0", openssl_cipher_iv_length($cipher));

        // $AESBase64 = openssl_encrypt($request->file, $cipher, $secret, $options, $iv);
        $AESBase64 = openssl_encrypt($fileBase64, $cipher, $aeskey, $options, $iv);

        Files::create([
            'filename' => $fileName,
            'extension' => $fileExtension,
            'file_base64' => $AESBase64,
            'fileOwner' => $userId,
            'secret' => $aeskey,
            'iv' => $iv,
        ]);

        return redirect('/files')->with('success', 'File Uploaded!');
    }

    // public function download($id) {
    //     $file = Files::find($id);

    //     if (!$file) {
    //         abort(404); // File not found
    //     }

    //     // Fetch the encrypted file content and decrypt it
    //     $cipher = "AES-256-CBC";
    //     $aeskey = $file->secret;
    //     $options = 0;
    //     $iv = $file->iv;

    //     $decrypted_AESBase64 = openssl_decrypt($file->file_base64, $cipher, $aeskey, $options, $iv);
    //     $fileContent = base64_decode($decrypted_AESBase64);

    //     // Set headers for file download
    //     $headers = [
    //         'Content-Type' => 'application/octet-stream',
    //         'Content-Disposition' => 'attachment; filename=' . $file->filename,
    //     ];

    //     // Return the download response
    //     return response()->make($fileContent, 200, $headers);
    // }

    public function download($id) {
        $file = Files::find($id);

        if (!$file) {
            abort(404); // File not found
        }

        // Check if the file is a duplicate
        if ($file->isDuplicate) {
            // Return a view with a form to ask for the private key
            return view('files.request_key', ['file' => $file]);
        }

        // Fetch the encrypted file content and decrypt it
        $cipher = "AES-256-CBC";
        $aeskey = $file->secret;
        $options = 0;
        $iv = $file->iv;

        $decrypted_AESBase64 = openssl_decrypt($file->file_base64, $cipher, $aeskey, $options, $iv);
        $fileContent = base64_decode($decrypted_AESBase64);

        // Set headers for file download
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=' . $file->filename,
        ];

        // Return the download response
        return response()->make($fileContent, 200, $headers);
    }

    public function decryptWithKey(Request $request, $id) {
        $file = Files::find($id);

        if (!$file) {
            abort(404); // File not found
        }

        // Fetch the private key from the request
        $privateKey = $request->input('private_key');


        // Fetch the encrypted file content and decrypt it
        $cipher = "AES-256-CBC";
        $options = 0;
        $iv = $file->iv;
        $decryptedPrivateKey = openssl_decrypt($privateKey, $cipher, env('AES_KEY_KEY'), $options, $iv);

        $decrypted_AESBase64 = openssl_decrypt($file->file_base64, $cipher, $decryptedPrivateKey, $options, $iv);
        $fileContent = base64_decode($decrypted_AESBase64);

        // Set headers for file download
        $headers = [
            'Content-Type' => 'application/octet-stream',
            'Content-Disposition' => 'attachment; filename=' . $file->filename,
        ];

        // Return the download response
        return response()->make($fileContent, 200, $headers);
    }

}
