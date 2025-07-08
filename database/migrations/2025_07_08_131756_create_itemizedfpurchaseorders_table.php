<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemizedfpurchaseordersTable extends Migration
{
    public function up()
    {
        Schema::create('itemizedfpurchaseorders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisition_id');
            $table->string('item')->nullable();
            $table->string('description')->nullable();
            $table->integer('quantity')->default(0);
            $table->decimal('price', 15, 2)->default(0);
            $table->decimal('weight', 15, 2)->nullable();
            $table->decimal('linetotal', 15, 2)->default(0);
            $table->decimal('vat', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('vattotal', 15, 2)->default(0);
            $table->decimal('grandtotal', 15, 2)->default(0);
            $table->timestamps();

            // Foreign key constraint if requisition_id relates to another table
            // $table->foreign('requisition_id')->references('id')->on('requisitions')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('itemizedfpurchaseorders');
    }
}
