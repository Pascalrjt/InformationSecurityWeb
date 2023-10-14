<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class filesController extends Controller {
    function upload() {
        return view("files.create");
    }

    function uploadFile(Request $request) {
        $file = $request->file("file");
        echo 'File Name: ' . $file->getClientOriginalName();
        echo '<br>';
        echo 'File Extension: ' . $file->getClientOriginalExtension();
        echo '<br>';
        echo 'File Real Path: ' . $file->getRealPath();
        echo '<br>';
        echo 'File Size: ' . $file->getSize();
        echo '<br>';
        echo 'File Mime Type: ' . $file->getMimeType();

        $destinationPath = "uploads";

        if($file->move($destinationPath, $file->getClientOriginalName())) {
            // echo "File Upload Success";
            return redirect()->route('files.index');
        } else {
            echo "Failed to upload file";
        }
    }

    public function index() {
    $files = Storage::files('uploads');

    return view('files.index', compact('files'));
    }
    
}
