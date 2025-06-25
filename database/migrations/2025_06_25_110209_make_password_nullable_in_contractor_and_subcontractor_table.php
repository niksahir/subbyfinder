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
        Schema::table('contractors', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->string('business_name')->nullable()->change();
            $table->string('contact_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });

        Schema::table('sub_contractors', function (Blueprint $table) {
            $table->string('password')->nullable()->change();
            $table->string('business_name')->nullable()->change();
            $table->string('contact_name')->nullable()->change();
            $table->string('phone')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contractor_and_subcontractor', function (Blueprint $table) {
            //
        });
    }
};
