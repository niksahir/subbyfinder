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
        Schema::create('unlocked_projects', function (Blueprint $table) {
            $table->id(); // auto-incrementing primary key
            $table->unsignedBigInteger('user_id');
            $table->string('user_type'); // user id for polymorphic relation
            $table->unsignedBigInteger('project_id'); // the associated project
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // for soft deletion

            // Foreign key constraint to contractor_projects table
            $table->foreign('project_id')->references('id')->on('contractor_projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unlocked_projects');
    }
};
