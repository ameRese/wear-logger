<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\WearLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('item', ItemController::class);

Route::post('wear_log/store/{item}', [WearLogController::class, 'store'])->name('wear_log.store');
Route::delete('wear_log/{wear_log}', [WearLogController::class, 'destroy'])->name('wear_log.destroy');

Route::get('stat', [StatController::class, 'index'])->name('stat.index');
Route::get('stat/unused_item', [StatController::class, 'unusedItem'])->name('stat.unused_item');
Route::get('stat/wear_rank', [StatController::class, 'wearRank'])->name('stat.wear_rank');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
