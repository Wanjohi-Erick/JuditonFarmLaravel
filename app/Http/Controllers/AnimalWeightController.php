<?php

namespace App\Http\Controllers;

use App\Models\AnimalWeight;
use Illuminate\Http\Request;

class AnimalWeightController extends Controller
{
    public function show() {

        return AnimalWeight::all();
    }
}
