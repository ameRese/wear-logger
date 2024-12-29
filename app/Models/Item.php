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

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function color() {
        return $this->belongsTo(Color::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function season() {
        return $this->belongsTo(Season::class);
    }

    public function wearLogs() {
        return $this->hasMany(WearLog::class);
    }

    public function wearCount() {
        $preRegistWearCount = $this->pre_regist_wear_count;
        $postRegistWearCount = $this->wearLogs()->count();
        return $preRegistWearCount + $postRegistWearCount;
    }

    public function latestWearLog() {
        return $this->wearLogs()->orderBy('wear_date', 'desc')->first();
    }
}
