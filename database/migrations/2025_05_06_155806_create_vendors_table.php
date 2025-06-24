<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->nullable();
            $table->integer('companyId');
            $table->string('description')->nullable();
            $table->string('vat_registered')->nullable();
            $table->string('local_international')->nullable();
            $table->string('contact_no_1')->nullable();
            $table->string('contact_no_2')->nullable();
            $table->string('supplier_code')->nullable();
            $table->string('vat_allocation')->nullable();
            $table->string('finance_manager')->nullable();
            $table->string('message')->nullable();
            $table->text('address')->nullable();
            $table->integer('status')->nullable();
            $table->boolean('active')->default(true);

            // Banking details
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_type')->nullable();
            $table->string('branch_code')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}
