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
        Schema::create('bankaccounts', function (Blueprint $table) {
            $table->id();
            $table->string('bankName')->nullable();
            $table->string('branch')->nullable();
            $table->string('accountName')->nullable();
            $table->string('accountType')->nullable();
            $table->string('accountNumber')->nullable();
            $table->string('accountPurpose')->nullable();
            $table->integer('companyId')->nullable();
            $table->string('branchCode')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('isActive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bankaccounts');
    }
};
