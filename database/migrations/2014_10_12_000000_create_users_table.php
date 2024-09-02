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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('userName');
            $table->integer('phoneNumber');
            $table->integer('companyId');
            $table->integer('executiveId');
            $table->integer('selectedCompanyId');
            $table->boolean('isActive');
            $table->string('companyName');
            $table->integer('department');
            $table->string('address');
            $table->string('position');
            $table->string('userrole');
            $table->integer('isActive');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('confirmPassword');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
