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
        Schema::create('assesment_header', function (Blueprint $table) {
            $table->id();
            $table->string('assesment_id');
            $table->string('assesment_desc');
            $table->string('assesment_type');
            $table->string('test_type');
            $table->string('filename');
            $table->integer('total_points');
            $table->integer('points_each');
            $table->date('deadline')->nullable();
            $table->string('subj_code');
            $table->string('section_code');
            $table->string('quarter_period');
            $table->string('sy');
            $table->string('status');
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
        Schema::dropIfExists('assesment_header');
    }
};
