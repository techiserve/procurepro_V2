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
            $table->string('bankName');
            $table->string('branch');
            $table->string('accountName');
            $table->string('accountType');
            $table->string('accountNumber');
            $table->string('accountPurpose');
            $table->integer('companyId');
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
