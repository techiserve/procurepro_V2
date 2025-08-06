<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('form_fields', function (Blueprint $table) {
            $table->id();
            $table->string('companyId'); // e.g., 'item_name'
            $table->string('name'); // e.g., 'item_name'
            $table->string('label'); // e.g., 'Item Name'
            $table->string('type'); // e.g., 'string', 'integer'
            $table->string('options'); // e.g., 'string', 'integer'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('form_fields');
    }
};
