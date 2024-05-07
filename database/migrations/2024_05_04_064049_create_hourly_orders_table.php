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
        Schema::create('hourly_orders', function (Blueprint $table) {
            $table->id();
            $table->string('Period');
            $table->bigInteger('number_of_hours');
            $table->string('nationality');
            $table->string('city');
            $table->foreignId('company_id')->references('id')->on('companies')->cascadeOnDelete();
            $table->foreignId('categorie_id')->references('id')->on('categories')->cascadeOnDelete();
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->text('address');
            $table->date('date');
            $table->time('time');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hourly_orders');
    }
};
