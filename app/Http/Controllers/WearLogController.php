<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\WearLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WearLogController extends Controller
{
    public function store(Request $request, Item $item) {
        $wearLog = WearLog::create([
            'item_id' => $item->id,
            'wear_date' => $request->date ?? today(),
        ]);
        $request->session()->flash('message', '着用記録を登録しました');
        return back();
    }

    public function destroy(Request $request, WearLog $wearLog) {
        $wearLog->delete();
        $request->session()->flash('message', '着用記録を解除しました');
        return back();
    }

    public function getWearDates(Item $item) {
        $wearDates = WearLog::where('item_id', $item->id)->pluck('wear_date');
        return response()->json($wearDates);
    }

    public function updateWearLogs(Request $request, Item $item) {
        $wearDatesToAdd = $request->input('wearDatesToAdd');
        $wearDatesToDelete = $request->input('wearDatesToDelete');
        foreach ($wearDatesToAdd as $wearDate) {
            WearLog::create([
                'item_id' => $item->id,
                'wear_date' => $wearDate,
            ]);
        }
        foreach ($wearDatesToDelete as $wearDate) {
            WearLog::where('wear_date', $wearDate)->where('item_id', $item->id)->delete();
        }
        $request->session()->flash('message', '着用記録を更新しました');
    }

    public function bulkStore(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
        ]);
        $items = Item::whereIn('id', $request->item_ids)->where('user_id', Auth::id())->get();
        foreach ($items as $item) {
            // 既に当日分が登録されていなければ登録
            if (!$item->isWearedToday()) {
                WearLog::create([
                    'item_id' => $item->id,
                    'wear_date' => now()->format('Y-m-d'),
                ]);
            }
        }
        $request->session()->flash('message', '着用記録を登録しました');
    }

    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
        ]);
        $items = Item::whereIn('id', $request->item_ids)->where('user_id', Auth::id())->get();
        foreach ($items as $item) {
            $item->getLatestWearLog()->delete();
        }
        $request->session()->flash('message', '着用記録を解除しました');
    }
}
