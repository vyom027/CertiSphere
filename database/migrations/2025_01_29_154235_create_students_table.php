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
        Schema::create('students', function (Blueprint $table) {
            $table->id('enrollment_no'); // Primary Key
            $table->unsignedBigInteger('batch_id'); // Foreign Key to batch table
            $table->unsignedBigInteger('dept_id'); // Foreign Key to department table
            $table->string('first_name')->nullable(false);
            $table->string('last_name')->nullable(false);
            $table->string('email')->unique()->nullable(false);
            $table->string('profile_picture')->nullable();
            $table->string('phone_number')->unique()->nullable(false);
            $table->enum('verified', ['Verified', 'Not Verified'])->nullable(false)->default('Not Verified');
            $table->timestamps();
            $table->unique(['enrollment_no', 'dept_id']);
            // Foreign key constraints
            $table->foreign('batch_id')->references('batch_id')->on('batch')->onDelete('cascade');
            $table->foreign('dept_id')->references('dept_id')->on('department')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
