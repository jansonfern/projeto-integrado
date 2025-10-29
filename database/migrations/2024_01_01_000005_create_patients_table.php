<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('cpf', 14)->unique();
            $table->date('birth_date');
            $table->string('phone', 20);
            $table->string('cep', 9)->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state', 2)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
}; 