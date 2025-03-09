<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
   /**
    * Run the migrations.
    */
   public function up(): void {
      Schema::table('users', function (Blueprint $table) {
         $table->string('business_name')->nullable();
         $table->string('contact_name')->nullable();
         $table->string('phone')->nullable();
         $table->longText('address')->nullable();
         $table->integer('support_staff_size')->nullable();
         $table->string('years_in_business')->nullable();
         $table->string('insurances')->nullable();
         $table->string('abn')->nullable();
         $table->string('licenses')->nullable();
         $table->string('expertise_in')->nullable();
         $table->string('project_type')->nullable();
         $table->string('availability')->nullable();
         $table->softDeletes();
      });
   }

   /**
    * Reverse the migrations.
    */
   public function down(): void {
      Schema::table('users', function (Blueprint $table) {
         //
      });
   }
};
