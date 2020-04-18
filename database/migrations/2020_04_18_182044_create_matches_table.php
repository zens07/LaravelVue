<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->integer('clubhome_id')->unsigned();
            $table->integer('clubaway_id')->unsigned();
            $table->string('score');
            $table->timestamps();

            $table->foreign('clubhome_id')
                ->references('id')->on('clubs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('clubaway_id')
                ->references('id')->on('clubs')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matches');
    }
}
