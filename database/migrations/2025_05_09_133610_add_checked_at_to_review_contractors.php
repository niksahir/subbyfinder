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
        Schema::table('review_contractors', function (Blueprint $table) {
            $table->timestamp('completion_estimate_checked_at')->nullable()->after('communication');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('review_contractors', function (Blueprint $table) {
            //
        });
    }
};
