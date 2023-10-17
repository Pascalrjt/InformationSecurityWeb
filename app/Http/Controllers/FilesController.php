<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Files;
use Exception;

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

    public function index()
    {
        $files = Files::all();

        return view('files.index', [
            'files' => $files,
            'title' => 'files'
        ]);
    }

    public function PDFToBase64($PDFPath) {
        try {
            $PDFData = file_get_contents($PDFPath);
            if ($PDFData === false) {
                throw new Exception("Failed to read the PDF file.");
            }
            
            $base64 = base64_encode($PDFData);
            return $base64;
        } catch (Exception $e) {
            echo "An error occurred: " . $e->getMessage();
            return null;
        }
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:225',
            'pdf' => 'pdf|file|max:2048' // Ensure the uploaded file is a pdf
        ]);

        $PDF = $request->file('PDF');
            if ($PDF) {
                $PDFBase64 = $this->PDFToBase64($PDF->getPathname());
            } else {
                $PDFBase64 = null; // or any default value you want to use
            }
    }
    
}
