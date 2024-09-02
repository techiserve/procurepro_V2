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
        Schema::create('company_roles', function (Blueprint $table) {
            $table->id();
            $table->string('userName')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('roleId')->nullable();
            $table->integer('isActive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_roles');
    }
};
