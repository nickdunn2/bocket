<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->string('link');
            $table->timestamps();
            // Still needs foreign key cascade delete. sqlite has foreign_keys disabled
            // Can't figure out how to enable -- PRAGMA foreign_keys = ON; did NOT work
            // Maybe just somehow delete the index instead?
//            $table->foreign('user_id')
//                  ->references('id')->on('users')
//                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bookmarks');
    }
}
