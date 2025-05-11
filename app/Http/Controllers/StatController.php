<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\WearLog;
use Illuminate\Http\Request;

class StatController extends Controller
{
    public function index() {
        return view('stat.index');
    }

    // 利用可能な年のリストを取得するメソッド
    private function getAvailableYears() {
        // ユーザーの全アイテムに関連する着用記録から、最も古い日付のものを見つける
        $userItemIds = Item::where('user_id', auth()->id())->pluck('id');
        $oldestWearLog = WearLog::whereIn('item_id', $userItemIds)->oldest('wear_date')->first();

        // 着用記録がない場合は現在年のみを返す
        $currentYear = today()->year;
        if (!$oldestWearLog) {
            return [$currentYear];
        }

        // 最古の年から現在年までの連続した年リストを生成
        $oldestYear = $oldestWearLog->wear_date->year;
        $years = [];
        for ($year = $currentYear; $year >= $oldestYear; $year--) {
            $years[] = $year;
        }

        return $years;
    }

    public function unusedItem(Request $request) {
        $selectedYear = $request->input('year', 'all');
        $query = Item::where('user_id', auth()->id());

        // 「全期間」が選択されている場合
        if ($selectedYear === 'all') {
            // 登録前の着用回数も含めて着用記録が全くないアイテムを取得
            $unusedItems = $query->doesntHave('wearLogs')
                ->where('pre_regist_wear_count', 0)
                ->orderBy('created_at')
                ->get();

        // 特定の年が選択されている場合
        } else {
            // 指定年に着用記録のないアイテムを取得
            $potentialUnusedItems = $query->whereDoesntHave('wearLogs',
                fn($wearLogs) => $wearLogs->whereYear('wear_date', $selectedYear)
            )->orderBy('created_at')->get();

            // その中から、購入日や最初の着用年を考慮してフィルタリング
            $unusedItems = $potentialUnusedItems->filter(function($item) use ($selectedYear) {
                // 購入日が登録されている場合
                if ($item->purchase_date) {
                    // 購入年が選択年より後の場合は未着用アイテムから除去
                    return $item->purchase_date->year <= $selectedYear;

                // 購入日が未登録の場合
                } else {
                    $firstWearLog = $item->wearLogs()->oldest('wear_date')->first();
                    // 着用記録が全くない場合は未着用アイテムに残す
                    if (!$firstWearLog) {
                        return true;
                    }

                    // 最初の着用年が選択年より後の場合は未着用アイテムから除去
                    return $firstWearLog->wear_date->year <= $selectedYear;
                }
            });
        }

        // select用に利用可能な年のリストを取得
        $availableYears = $this->getAvailableYears();

        return view('stat.unused-item', compact('unusedItems', 'availableYears', 'selectedYear'));
    }

    public function wearRank() {
        $wearCountSortedItems = Item::where('user_id', auth()->id())
            ->withCount('wearLogs')
            ->get()
            ->sortByDesc(fn($item) => $item->wear_logs_count + $item->pre_regist_wear_count);
        return view('stat.wear-rank', compact('wearCountSortedItems'));
    }
}
