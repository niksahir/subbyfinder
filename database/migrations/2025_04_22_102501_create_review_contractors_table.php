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
        Schema::create('review_contractors', function (Blueprint $table) {
            $table->id();

            // Polymorphic relationship for user
            $table->unsignedBigInteger('user_id')->index();
            $table->string('user_type');

            // Polymorphic relationship for project
            $table->unsignedBigInteger('project_id')->index();
            $table->string('project_type');

            // Review form fields
            $table->enum('contacted', ['yes', 'no'])->nullable();
            $table->string('reason_no_contact')->nullable();

            $table->enum('agreed', ['yes', 'no'])->nullable();
            $table->text('dealings_review')->nullable();

            $table->enum('completed', ['yes', 'no'])->nullable();
            $table->text('final_review')->nullable();

            $table->string('completion_estimate')->nullable(); // values like: 7, 30, 90

            // Star ratings (1 to 5)
            $table->tinyInteger('workmanship')->nullable();
            $table->tinyInteger('integrity')->nullable();
            $table->tinyInteger('presentation')->nullable();
            $table->tinyInteger('communication')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_contractors');
    }
};
