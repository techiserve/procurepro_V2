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
            $table->string('name')->nullable();
            $table->string('domain')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('confirmPassword')->nullable();
            $table->string('contactPerson')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('vendor_source')->nullable();
            $table->string('user')->nullable();
            $table->boolean('IsActive')->nullable();
            $table->integer('phoneNumber')->nullable();
            $table->integer('userrole')->nullable();
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
