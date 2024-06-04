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
        Schema::create('product', function (Blueprint $table) {
            $table->id()->increments();
            $table->string('image');
            $table->string('title');
            $table->text('description');
            $table->bigInteger('price');
            $table->integer('stock')->default(0);
            $table->unsignedSmallInteger('category');
            $table->foreign('category')->references('id')->on('category')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
