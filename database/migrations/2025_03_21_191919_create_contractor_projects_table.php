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
        Schema::create('contractor_projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contractor_id');
            $table->string('project_logo')->nullable();
            $table->string('project_name');
            $table->string('location');
            $table->text('description')->nullable();
            $table->string('abn')->nullable();
            $table->string('license')->nullable();
            $table->json('trade_category')->nullable();
            $table->string('budget');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('contractor_id')->references('id')->on('contractors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractor_projects');
    }
};
