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
        Schema::create('caes_profile', function (Blueprint $table) {
            $table->id();
            $table->string('school_name');
            $table->integer('school_year')->unique();
            $table->string('school_address')->nullable();
            $table->string('school_type')->nullable();
            $table->string('school_logo')->nullable();
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
        Schema::dropIfExists('caes_profile');
    }
};
