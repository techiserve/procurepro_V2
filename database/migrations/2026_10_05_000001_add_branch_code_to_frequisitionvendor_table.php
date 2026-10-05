<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('frequisitionvendor', 'branchCode')) {
            Schema::table('frequisitionvendor', function (Blueprint $table) {
                $table->string('branchCode')->nullable();
            });
        }
    }

    public function down(): void
    {
        // The column may have existed before this migration on older installations.
    }
};
