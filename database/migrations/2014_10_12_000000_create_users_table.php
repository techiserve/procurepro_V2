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
            $table->string('name')->nullable();
            $table->string('userName')->nullable();
            $table->integer('phoneNumber')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('executiveId')->nullable();
            $table->integer('selectedCompanyId')->nullable();
            $table->string('companyName')->nullable();
            $table->string('vendor_source')->nullable();
            $table->integer('department')->nullable();
             $table->integer('login_attempts')->default(0);
            $table->boolean('is_locked')->default(false);
            $table->string('address')->nullable();
            $table->string('position')->nullable();
            $table->string('userrole')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('confirmPassword')->nullable();
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
