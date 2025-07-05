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
        Schema::table('subcontractor_protfolios', function (Blueprint $table) {
            $table->string('place_id')->nullable()->after('location');
            $table->decimal('lat', 10, 7)->nullable()->after('place_id');
            $table->decimal('lng', 10, 7)->nullable()->after('lat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subcontractor_protfolios', function (Blueprint $table) {
            //
        });
    }
};
