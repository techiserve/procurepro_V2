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
        Schema::create('departmentapprovals', function (Blueprint $table) {
            $table->id();
            $table->string('department')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('departmentId')->nullable();
            $table->integer('approvalId')->nullable();
            $table->integer('roleId')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departmentapprovals');
    }
};
