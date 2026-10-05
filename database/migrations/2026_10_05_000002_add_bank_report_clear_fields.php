<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['frequisitions', 'fpurchaseorders'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->timestamp('bank_report_cleared_at')->nullable();
                $table->unsignedBigInteger('bank_report_cleared_by')->nullable();
            });
        }
    }

    public function down(): void
    {
        foreach (['frequisitions', 'fpurchaseorders'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn(['bank_report_cleared_at', 'bank_report_cleared_by']);
            });
        }
    }
};
