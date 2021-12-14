<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMissingColumnsToHeartbeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('heartbeats', function (Blueprint $table) {
            $table->string('editor')->after('user_agent')->nullable();
            $table->string('machine')->after('user_agent')->nullable();
            $table->string('operating_system')->after('user_agent')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('heartbeats', function (Blueprint $table) {
            $table->dropColumn('editor');
            $table->dropColumn('machine');
            $table->dropColumn('operating_system');
        });
    }
}
