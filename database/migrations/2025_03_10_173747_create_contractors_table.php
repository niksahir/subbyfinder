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
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('profile_photo')->nullable();
            $table->string('business_name');
            $table->string('contact_name');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('address')->nullable();
            $table->integer('support_staff_size')->nullable();
            $table->string('years_in_business')->nullable();
            $table->text('insurances')->nullable();
            $table->string('abn')->nullable();
            $table->text('licenses')->nullable();
            $table->json('expertise_in')->nullable();
            $table->json('project_types')->nullable();
            $table->json('availability')->nullable();
            $table->text('description')->nullable();
            $table->text('values')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contractors');
    }
};
