<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificateSubmissionsTable extends Migration
{
    public function up()
    {
        Schema::create('certificate_submissions', function (Blueprint $table) {
            $table->id();

            // Student & Enrollment
            $table->unsignedBigInteger('enrollment_no'); 

            // Certificate Request
            $table->unsignedBigInteger('certificate_request_id');

            // Batch & Department Info
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('dept_id');
            $table->string('division');

            // Certificate File
            $table->string('certificate_file'); // PDF stored path
            $table->timestamp('submitted_at')->nullable();

            // Status
            $table->enum('status', ['Approved', 'Not Approved'])->default('Not Approved');

            $table->timestamps();

            // Foreign key constraints
            
            $table->foreign('certificate_request_id')->references('id')->on('certificate_requests')->onDelete('cascade');
            $table->foreign('batch_id')->references('batch_id')->on('batch')->onDelete('cascade');
            $table->foreign('dept_id')->references('dept_id')->on('department')->onDelete('cascade');

            // Optional: enforce enrollment_no uniqueness or relation
            $table->foreign('enrollment_no')->references('enrollment_no')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificate_submissions');
    }
}
