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
        Schema::create('fpurchaseorders', function (Blueprint $table) {
            $table->id();
            $table->integer('frequisition_id')->nullable();
            $table->integer('companyId')->nullable();
            $table->integer('invoiceamount')->nullable();
            $table->string('requisitionNumber');
            $table->integer('department')->nullable();
            $table->string('jobcardfile')->nullable();
            $table->string('subtotal')->nullable();
            $table->string('vattotal')->nullable();
            $table->string('pop')->nullable();
            $table->string('benref')->nullable();
            $table->string('ownref')->nullable();
            $table->integer('userId')->nullable();
            $table->integer('status')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('vendor')->nullable();
            $table->integer('purchaseorderstatus')->nullable();
            $table->integer('balance')->nullable();
            $table->integer('isActive')->nullable();
            $table->string('approvallevel')->nullable();
            $table->integer('totalapprovallevels')->nullable();
            $table->string('reason')->nullable();
            $table->string('approvedby')->nullable();
            $table->string('releaseStatus')->nullable();
            $table->string('uploadStatus')->nullable();

            $table->string('bankAccountName')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('bankAccountType')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fpurchaseorders');
    }
};
