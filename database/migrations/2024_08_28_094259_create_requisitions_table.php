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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('vendor')->nullable();
            $table->string('services')->nullable();
            $table->integer('companyId')->nullable();
            $table->string('paymentmethod')->nullable();
            $table->string('expenses')->nullable();
            $table->string('projectcode')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('department')->nullable();
            $table->string('file')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('PropertyCode')->nullable();
            $table->string('TransactionCode')->nullable();
            $table->string('TaxTypeCode')->nullable();
            $table->string('PropertyName')->nullable();
            $table->string('TransactionDescription')->nullable();
            $table->string('TaxTypeDescription')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('status')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('approvallevel')->nullable();
            $table->integer('totalapprovallevels')->nullable();
            $table->string('reason')->nullable();
            $table->string('approvedby')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisitions');
    }
};
