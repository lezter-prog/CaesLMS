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
        Schema::create('process_school_year', function (Blueprint $table) {
            $table->id();
            $table->string('school_year');
            $table->string('teacher_id');
            $table->string('activity_status');
            $table->string('quizes_status');
            $table->string('exams_status');
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
        Schema::dropIfExists('process_school_year');
    }
};
