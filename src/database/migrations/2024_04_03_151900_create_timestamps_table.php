<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimestampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timestamps', function (Blueprint $table)
        {
            $table->increments('id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->datetime('workIn');
            $table->datetime('workOut')->nullable();
            $table->datetime('breakIn')->nullable();
            $table->time('breakTime')->nullable();
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
        Schema::dropIfExists('timestamps');
    }
}
