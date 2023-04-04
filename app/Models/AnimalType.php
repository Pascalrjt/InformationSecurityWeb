<?php

namespace App\Models;

use App\Models\Animals;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnimalType extends Model
{
    use HasFactory;

    protected $table = "animals";
    protected $fillable = ["type"];

    public function animal(){
        return $this->hasMany(Animals::class);
    }
}
