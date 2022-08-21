<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPlayerApprovalStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournament_players', function (Blueprint $table) {
            $table->string('host_approval')->default('2'); // 2 = pending, 1 = approved, 0 = rejected

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournament_players', function (Blueprint $table) {
            $table->dropColumn('host_approval');
        });
    }
}
