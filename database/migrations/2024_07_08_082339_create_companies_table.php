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
            $table->string('domain');
            $table->string('username');
            $table->string('password');
            $table->string('confirmPassword');
            $table->string('contactPerson');
            $table->string('email');
            $table->string('address');
            $table->string('user');
            $table->boolean('IsActive');
            $table->integer('phoneNumber');
            $table->integer('userrole');
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
