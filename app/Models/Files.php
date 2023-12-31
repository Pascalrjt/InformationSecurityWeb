<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Files extends Model {
    // use HasFactory;

    protected $fillable = [
        'filename',
        'extension',
        'file_base64',
        'fileOwner',
        'secret',
        'isDuplicate',
        'iv',
    ];
}
