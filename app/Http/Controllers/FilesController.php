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
        $secret = "12345678901234567890123456789012";

        //Iv
        $options = 0;
        $iv = str_repeat("0", openssl_cipher_iv_length($cipher));

        // $AESBase64 = openssl_encrypt($request->file, $cipher, $secret, $options, $iv);
        $AESBase64 = openssl_encrypt($fileBase64, $cipher, $secret, $options, $iv);

        Files::create([
            'filename' => $fileName,
            'extension' => $fileExtension,
            'file_base64' => $AESBase64,
            'fileOwner' => $userId
        ]);

        return redirect('/files')->with('success', 'File Uploaded!');
    }

}
