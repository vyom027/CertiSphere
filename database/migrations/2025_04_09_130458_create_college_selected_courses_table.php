<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;



class CreateCollegeSelectedCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('college_selected_courses', function (Blueprint $table) {
            $table->id(); 
            $table->string('name', 100)->collation('utf8mb4_unicode_ci');
            $table->text('link')->collation('utf8mb4_unicode_ci'); 
            $table->integer('semester'); 
            $table->string('department', 100)->collation('utf8mb4_unicode_ci');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('college_selected_courses');
    }
}