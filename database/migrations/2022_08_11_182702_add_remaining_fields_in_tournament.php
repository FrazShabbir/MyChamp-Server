<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemainingFieldsInTournament extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament', function (Blueprint $table) {
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('end_date')->nullable();
            $table->string('repeat')->nullable();
            $table->string('category')->nullable();
            $table->string('format')->nullable();
         
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament', function (Blueprint $table) {
            $table->dropColumn('country');
            $table->dropColumn('state');
            $table->dropColumn('end_date');
            $table->dropColumn('repeat');
            $table->dropColumn('category');
            $table->dropColumn('format');
        });
    }
}
