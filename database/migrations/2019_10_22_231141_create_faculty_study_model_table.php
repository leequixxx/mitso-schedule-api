<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyStudyModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_study_model', function (Blueprint $table) {
            $table->string('faculty_name');
            $table->foreign('faculty_name')->references('name')->on('faculties')->onDelete('cascade');

            $table->string('study_model_name');
            $table->foreign('study_model_name')->references('name')->on('study_models')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('faculty_study_model');
    }
}
