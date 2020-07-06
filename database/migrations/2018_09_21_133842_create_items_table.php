<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Item = jeden druh položky (třeba "polévková lžíce")
         */
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->string('description')->nullable();

            $table->integer('owner_user_id')->nullable();
            $table->integer('owner_group_id')->nullable();

            // Pouze informační, nevypovídá o reálném stavu.
            $table->integer('home_place_id')->nullable();
            $table->integer('home_box_id')->nullable();

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
        Schema::dropIfExists('items');
    }
}
