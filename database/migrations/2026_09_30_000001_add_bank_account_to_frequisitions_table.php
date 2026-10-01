<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frequisitions', function (Blueprint $table) {
            $table->string('bankAccountName')->nullable();
            $table->string('bankAccountNumber')->nullable();
            $table->string('bankAccountType')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('frequisitions', function (Blueprint $table) {
            $table->dropColumn(['bankAccountName', 'bankAccountNumber', 'bankAccountType']);
        });
    }
};
