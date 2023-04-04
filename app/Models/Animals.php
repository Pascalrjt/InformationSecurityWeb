<?php

namespace App\Models;

use App\Models\Centers;
use App\Models\AnimalType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Animals extends Model
{
    use HasFactory;

    protected $table = "animals";
    protected $fillable = ["name","animaltype_id","breed", "age", "center_id", "image", "desc"];

    public function center(){
        return $this->belongsTo(Centers::class);
    }

    public function animaltype(){
        return $this->belongsTo(AnimalType::class);
    }

    // public function adoptionplan(){
    //     return $this->hasMany(Animals::class);
    // }
}
