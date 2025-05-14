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

    // purchase_dateは日付型 (Carbonインスタンス) として扱う
    protected function casts(): array {
        return [
            'purchase_date' => 'date',
        ];
    }

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

    public function getWearCount($year = null) {
        if ($year === null || $year === 'all') {
            // 期間未指定または全期間の場合
            $preRegistWearCount = $this->pre_regist_wear_count;
            $postRegistWearCount = $this->wearLogs()->count();
            return $preRegistWearCount + $postRegistWearCount;
        } else {
            // 特定年が指定された場合
            return $this->wearLogs()->whereYear('wear_date', $year)->count();
        }
    }

    public function getLatestWearLog() {
        return $this->wearLogs()->orderBy('wear_date', 'desc')->first();
    }

    public function isWearedToday() {
        return $this->getLatestWearLog()?->wear_date->isToday();
    }
}
