<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrequisitionvendorTable extends Migration
{
    public function up()
    {
        Schema::create('frequisitionvendor', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_final')->nullable();
            $table->string('file_path')->nullable();
            $table->integer('frequisition_id')->nullable();
            $table->integer('status')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            // Optional fields for one-time vendor modal
            $table->string('modal_vendor_name')->nullable();
            $table->string('type')->nullable();
            $table->string('vat_allocation')->nullable();
            $table->string('supplier_code')->nullable();
            $table->string('bank')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();
            $table->string('doc_path')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frequisitionvendor');
    }
}
