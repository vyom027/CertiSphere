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
        Schema::create('batch', function (Blueprint $table) {
            $table->id('batch_id');
            $table->unsignedBigInteger('dept_id')->nullable(false); 
            $table->year('start_year')->nullable(false);
            $table->year('end_year')->nullable(false);
            $table->foreign('dept_id')->references('dept_id')->on('department')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
