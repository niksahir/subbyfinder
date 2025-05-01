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
        Schema::create('additional_pays', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('price')->default(0);
            $table->string('user_type');
            $table->string('payable_type');
            $table->boolean('is_over')->default(false);
            $table->text('stripe_session_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('additional_pays');
    }
};
