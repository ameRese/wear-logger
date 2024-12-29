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
}
