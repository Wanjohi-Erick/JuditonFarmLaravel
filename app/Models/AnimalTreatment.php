<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalTreatment extends Model
{
    use HasFactory;

    protected $table = 'animal_treatment';

    public function farmAnimal() {
        return $this->belongsTo(AllAnimals::class, 'animal_id');
    }
}
