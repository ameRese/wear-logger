<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WearLog extends Model
{
    protected $fillable = [
        'item_id',
        'wear_date',
    ];
    
    public function item() {
        return $this->belongsTo(Item::class);
    }
}
