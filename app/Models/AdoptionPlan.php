<?php

namespace App\Models;

use App\Models\Animals;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdoptionPlan extends Model
{
    use HasFactory;

    protected $table = "adoption_plans";

    protected $fillable = [
        'animal_id',
        'user_id',
        'adopter_name',
        'adopter_email',
    ];
    
    public function animal(){
        return $this->belongsTo(Animals::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
