<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class StatisticTableCreate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('statistic', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('link_id');
            $table->string('country', 64);
            $table->string('city', 64);
            $table->string('user_agent', 256);
            $table->timestamps();
            $table->index('link_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statistic');
    }
}
