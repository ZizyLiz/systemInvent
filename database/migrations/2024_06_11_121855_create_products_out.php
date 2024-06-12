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
        Schema::create('products_out', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_keluar')->format('Y-m-d');
            $table->integer('qty_keluar');
            $table->unsignedSmallInteger('product_id');
            $table->foreign('product_id')->references('id')->on('product')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_out');
    }
};
