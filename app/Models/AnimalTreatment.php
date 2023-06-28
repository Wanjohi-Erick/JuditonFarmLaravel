<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalTreatment extends Model
{
    use HasFactory;

    protected $table = 'animal_treatment';
    protected $fillable = [
        'animal_id',
        'type',
        'product',
        'dapplication_method',
        'days_until_withdrawal',
        'technician',
        'dosage',
        'treatment_date',
        'body_parts',
        'booster_date',
        'total_cost',
        'description',
    ];

    public function farmAnimal() {
        return $this->belongsTo(AllAnimals::class, 'animal_id');
    }
}
