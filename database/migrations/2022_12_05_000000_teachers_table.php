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
        Schema::create('sy_teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('handled_s_code')->nullable();
            $table->string('handled_g_code')->nullable();
            $table->string('sy');
            $table->string('status');
            $table->string('addedBy');
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
        Schema::dropIfExists('sy_teachers');
    }
};
