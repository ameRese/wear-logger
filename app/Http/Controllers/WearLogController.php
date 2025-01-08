<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\WearLog;
use Illuminate\Http\Request;

class WearLogController extends Controller
{
    public function store(Request $request, Item $item) {
        $wearLog = WearLog::create([
            'item_id' => $item->id,
            'wear_date' => $request->date ?? today(),
        ]);
        $request->session()->flash('message', '保存しました');
        return back();
    }

    public function destroy(Request $request, WearLog $wearLog) {
        $wearLog->delete();
        $request->session()->flash('message', '削除しました');
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
    }
}
