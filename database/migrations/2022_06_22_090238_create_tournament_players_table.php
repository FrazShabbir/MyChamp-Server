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
        Schema::create('tournament_players', function (Blueprint $table) {
            $table->id('id');
            $table->string('tournament_id');
            $table->string('type');
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->string('phone');
            $table->string('image');
            $table->string('level');
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
        Schema::dropIfExists('tournament_players');
    }
};
