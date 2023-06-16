<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllAnimals extends Model
{
    use HasFactory;

    protected $table = 'all_animals';

    protected $fillable = [
        'animal_id',
        'img',
        'tag',
        'date_acquired',
        'breed',
        'weight',
        'date_last_weighed',
        'gender',
        'description',
    ];

    public function farmAnimal() {
        return $this->belongsTo(AnimalCategory::class, 'animal_id');
    }

    public function animalBreed() {
        return $this->belongsTo(Breed::class, 'breed');
    }
}
