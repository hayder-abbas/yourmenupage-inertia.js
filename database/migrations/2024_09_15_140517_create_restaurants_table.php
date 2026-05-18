<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('rest_name', 50);
            $table->string('rest_desc')->nullable();
            $table->string('rest_logo')->nullable();
            $table->string('location');
            $table->time('open_at');
            $table->time('close_at');
            $table->timestamps();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('city_id')
                ->constrained();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
