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
        Schema::create('executive_roles', function (Blueprint $table) {
            $table->id();
            $table->integer('executiveId')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('roleId')->nullable();
            $table->integer('status')->nullable();
            $table->string('createdBy')->nullable();
            $table->integer('IsActive')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_roles');
    }
};
