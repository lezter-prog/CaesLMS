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
        Schema::create('section_subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->string('subj_code');
            $table->string('sec_code');
            $table->string('g_code');
            $table->string('teacher_id');
            $table->string('sy');
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
        Schema::dropIfExists('section_subject_teacher');
    }
};
