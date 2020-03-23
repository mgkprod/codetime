<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeartbeatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heartbeats', function (Blueprint $table) {
            $table->id();
            $table->string('entity');
            $table->string('type')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_write')->nullable();
            $table->string('project')->nullable();
            $table->string('branch')->nullable();
            $table->string('language')->nullable()->index();
            $table->string('user_agent')->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heartbeats');
    }
}
