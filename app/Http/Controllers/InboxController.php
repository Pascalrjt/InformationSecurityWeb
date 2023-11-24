<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileRequest;
use App\Models\Files;

class InboxController extends Controller
{
    public function index()
    {
        $file_requests = FileRequest::all();
        $files = Files::where('fileOwner', auth()->id())->get();
        return view('inbox.index', compact('file_requests', 'files'));
    }
}
