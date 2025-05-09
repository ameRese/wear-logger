<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Item;
use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::where('user_id', auth()->id())
            ->get()
            ->sortByDesc(fn($item) => $item->getLatestWearLog()?->wear_date ?? null);
        return view('item.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $colors = Color::all();
        $brands = Brand::all();
        $seasons = Season::all();
        return view('item.create', compact('categories', 'colors', 'brands', 'seasons'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'color_id' => 'required',
            'brand_id' => 'required',
            'season_id' => 'required',
            'price' => 'nullable|integer',
            'purchase_date' => 'nullable|date',
            'pre_regist_wear_count' => 'nullable|integer',
        ]);
        $validated['pre_regist_wear_count'] ??= 0;
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('img', $file);
            $validated['image_path'] = $path;
        }

        $item = Item::create($validated);
        $request->session()->flash('message', 'アイテムを登録しました');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return view('item.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        $categories = Category::all();
        $colors = Color::all();
        $brands = Brand::all();
        $seasons = Season::all();
        return view('item.edit', compact('item', 'categories', 'colors', 'brands', 'seasons'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'color_id' => 'required',
            'brand_id' => 'required',
            'season_id' => 'required',
            'price' => 'nullable|integer',
            'purchase_date' => 'nullable|date',
            'pre_regist_wear_count' => 'nullable|integer',
        ]);
        $validated['pre_regist_wear_count'] ??= 0;
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = Storage::disk('public')->putFile('img', $file);
            $validated['image_path'] = $path;
        }

        $item->update($validated);
        $request->session()->flash('message', 'アイテム情報を更新しました');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Item $item)
    {
        // 画像があれば削除
        if ($item->image_path) {
            Storage::delete('public/' . $item->image_path);
        }
        $item->delete();
        $request->session()->flash('message', 'アイテムを削除しました');
        return redirect()->route('item.index');
    }

    // 一括でアイテムを削除
    public function bulkDestroy(Request $request)
    {
        $request->validate([
            'item_ids' => 'required|array',
            'item_ids.*' => 'exists:items,id',
        ]);
        $items = Item::whereIn('id', $request->item_ids)->where('user_id', Auth::id())->get();
        foreach ($items as $item) {
            // 画像があれば削除
            if ($item->image_path) {
                Storage::delete('public/' . $item->image_path);
            }
            // アイテム削除（関連する着用記録はカスケード削除される）
            $item->delete();
        }
        return response()->json(['message' => '複数のアイテムを削除しました'], 200);
    }
}
