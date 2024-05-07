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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price');
            $table->text('path');
            $table->foreignId('categorie_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('nationality');
            $table->string('tybe');
            $table->integer('numbers');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
