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
        Schema::create('requisition_histories', function (Blueprint $table) {
            $table->id();
            $table->string('vendor')->nullable();
            $table->string('services')->nullable();
            $table->string('paymentmethod')->nullable();
            $table->string('expenses')->nullable();
            $table->string('projectcode')->nullable();
            $table->integer('amount')->nullable();
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
        Schema::dropIfExists('requisition_histories');
    }
};
