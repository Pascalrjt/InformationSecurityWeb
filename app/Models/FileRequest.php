<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FileRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requested_id',
        'requester_id',
        'has_access', // Add the new field here
    ];

    protected $attributes = [
        'has_access' => false, // Set the default value for has_access
    ];
}
