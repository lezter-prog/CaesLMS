<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_assessment_answer', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('sec_code');
            $table->string('subj_code');
            $table->string('assesment_id');
            $table->integer('number');
            $table->string('question');
            $table->string('answer')->nullable();
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
        Schema::dropIfExists('student_assessment_answer');
    }
};
