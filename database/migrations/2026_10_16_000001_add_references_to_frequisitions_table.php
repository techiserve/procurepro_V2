<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frequisitions', function (Blueprint $table) {
            $table->string('benref')->nullable();
            $table->string('ownref')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('frequisitions', function (Blueprint $table) {
            $table->dropColumn(['benref', 'ownref']);
        });
    }
};
