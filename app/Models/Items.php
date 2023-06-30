<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    use HasFactory;

    protected $table = 'items';
    public function itemStock()
    {
        return $this->hasOne(ItemStock::class, 'item_id');
    }
}
