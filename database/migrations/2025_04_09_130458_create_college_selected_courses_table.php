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

            // Student & Request Relations
            $table->unsignedBigInteger('certificate_request_id');

            // Optional duplications for convenience or indexing
            $table->unsignedBigInteger('student_id');
            $table->string('enrollment_no');
            $table->unsignedBigInteger('batch_id');
            $table->unsignedBigInteger('dept_id');
            $table->string('division');

            // File and submission info
            $table->string('certificate_file'); // path to the uploaded PDF
            $table->timestamp('submitted_at')->nullable();

            // Approval Status
            $table->enum('status', ['Approved', 'Not Approved'])->default('Not Approved');

            $table->timestamps();

            // Foreign keys
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('certificate_request_id')->references('id')->on('certificate_requests')->onDelete('cascade');
            $table->foreign('batch_id')->references('batch_id')->on('batches')->onDelete('cascade');
            $table->foreign('dept_id')->references('dept_id')->on('departments')->onDelete('cascade');

            // Optional: enforce enrollment_no uniqueness or relation
            $table->foreign('enrollment_no')->references('enrollment_no')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificate_submissions');
    }
}