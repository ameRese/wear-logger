<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'image_path',
        'name',
        'category_id',
        'color_id',
        'brand_id',
        'season_id',
        'price',
        'purchase_date',
        'pre_regist_wear_count',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
