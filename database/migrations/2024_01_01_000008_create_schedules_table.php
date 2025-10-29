<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->date('date');
            $table->time('available_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
}; 