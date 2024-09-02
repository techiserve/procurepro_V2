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
        Schema::create('executives', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('userName')->nullable();
            $table->string('confirmPassword')->nullable();
            $table->string('password')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->integer('companyId')->nullable();
            $table->boolean('IsActive')->nullable();
            $table->integer('phonenumber')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executives');
    }
};
