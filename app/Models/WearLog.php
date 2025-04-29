<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WearLog extends Model
{
    protected $fillable = [
        'item_id',
        'wear_date',
    ];

    // wear_dateは日付型 (Carbonインスタンス) として扱う
    protected function casts(): array {
        return [
            'wear_date' => 'date',
        ];
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
