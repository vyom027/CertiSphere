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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Unique user ID
            $table->string('email')->unique()->nullable(false); // User email
            $table->string('password')->nullable(false); // User password
            $table->enum('usertype', ['admin', 'faculty', 'student'])->nullable(false); // User type
            $table->unsignedBigInteger('userable_id'); // Polymorphic ID
            $table->string('userable_type'); // Polymorphic Type (e.g., Student, Faculty, Admin)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
