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
        Schema::create('purchaseorders', function (Blueprint $table) {
            $table->id();
            $table->integer('requisition_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->string('vendor')->nullable();
            $table->string('services')->nullable();
            $table->string('paymentmethod')->nullable();
            $table->string('expenses')->nullable();
            $table->string('projectcode')->nullable();
            $table->string('SupplierCode')->nullable();
            $table->string('PropertyCode')->nullable();
            $table->string('TransactionCode')->nullable();
            $table->string('TaxTypeCode')->nullable();
            $table->string('PropertyName')->nullable();
            $table->string('TransactionDescription')->nullable();
            $table->string('TaxTypeDescription')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('invoiceamount')->nullable();
            $table->integer('department')->nullable();
            $table->string('jobcardfile')->nullable();
            $table->string('invoice')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('status')->nullable();
            $table->integer('purchaseorderstatus')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('approvallevel')->nullable();
            $table->integer('totalapprovallevels')->nullable();
            $table->string('reason')->nullable();
            $table->string('approvedby')->nullable();
            $table->string('releaseStatus')->nullable();
            $table->string('uploadStatus')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchaseorders');
    }
};
