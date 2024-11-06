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
        Schema::create('requisitionfiles', function (Blueprint $table) {
            $table->id();
            $table->integer('requisitionId')->nullable();
            $table->integer('companyId')->nullable();
            $table->string('file')->nullable();
            $table->integer('userId')->nullable();
            $table->string('path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitionfiles');
    }
};
