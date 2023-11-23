<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FileRequest;

class InboxController extends Controller
{
    public function index()
    {
        $file_requests = FileRequest::all();
        return view('inbox.index', compact('file_requests'));
    }
}
