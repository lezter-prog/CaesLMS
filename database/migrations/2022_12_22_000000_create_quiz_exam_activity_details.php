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
        Schema::create('assesment_details', function (Blueprint $table) {
            $table->id();
            $table->string('assesment_id');
            $table->integer('number')->nullable();
            $table->string('question')->nullable();
            $table->string('choice_A')->nullable();
            $table->string('choice_B')->nullable();
            $table->string('choice_C')->nullable();
            $table->string('choice_D')->nullable();
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
        Schema::dropIfExists('assesment_details');
    }
};
