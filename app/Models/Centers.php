<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Centers extends Model
{
    use HasFactory;

    protected $table = "centers";
    protected $fillable = ["name", "location", "telephone", "email"];

    public function animal(){
        return $this->hasMany(Animals::class);
    }

    // public function create()
    // {
    //     $angkatans = Centers::all();
    //     return view('animals.create', compact('centers'));
    // }
}