<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    public function items() {
        return $this->hasMany(Item::class);
    }
}
