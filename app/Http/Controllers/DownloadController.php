<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Files;
use Exception;

class DownloadController extends Controller
{
    public function index()
    {
        $files = Files::all();

        return view('files.index', [
            'files' => $files,
            'title' => 'files'
        ]);
    }

    public function downloadPage($id) {
        $value = $id;
        return view('files.download', [
            'title' => 'download'
        ],compact('value'));
    }

    public function download(Request $request, $id) {
        
    }
}
