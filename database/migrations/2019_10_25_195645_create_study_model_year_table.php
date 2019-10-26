<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudyModelYearTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_model_year', function (Blueprint $table) {
            $table->string('study_model_name');
            $table->foreign('study_model_name')->references('name')->on('study_models')->onDelete('cascade');

            $table->string('year_name');
            $table->foreign('year_name')->references('name')->on('years')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('study_model_year');
    }
}
