<?php

namespace App\Http\Controllers;

use App\Models\ItemStock;
use Illuminate\Http\Request;

class ItemStockController extends Controller
{
    public function getAllItems() {
        return ItemStock::all();
    }
}
