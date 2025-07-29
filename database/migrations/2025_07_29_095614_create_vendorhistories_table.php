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
        Schema::create('vendorhistories', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id')->nullable();
            $table->integer('companyId')->nullable();
            $table->string('department')->nullable();
            $table->string('action')->nullable();
            $table->string('file')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('status')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('approvallevel')->nullable();
            $table->string('reason')->nullable();
            $table->string('doneby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendorhistories');
    }
};
