<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->text('image_path')->nullable();
            $table->text('name');
            $table->foreignId('category_id');
            $table->foreignId('color_id');
            $table->foreignId('brand_id');
            $table->foreignId('season_id');
            $table->integer('price')->nullable();
            $table->date('purchase_date')->nullable();
            $table->integer('pre_regist_wear_count')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
