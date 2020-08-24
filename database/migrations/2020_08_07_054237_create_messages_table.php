<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            //$table->integer('interior_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('interior_id')->unsigned()->index();
            $table->text('body');
            $table->timestamps();

            //$table->foreign('interior_id')->references('id')->on('interiors');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('interior_id')->references('id')->on('interiors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
