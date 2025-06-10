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
        Schema::create('frequisitions', function (Blueprint $table) {
            $table->id();
            $table->integer('companyId');
            $table->integer('userId');
            $table->string('requisitionNumber');
            $table->integer('status');
            $table->integer('isActive');
            $table->string('approvallevel');
            $table->string('totalapprovallevels');
            $table->string('reason');
            $table->string('approvedby');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('frequisitions');
    }
};
