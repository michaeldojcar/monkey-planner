<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemStatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Výskyt jednoho druhu itemu na jednom místě.
         */
        Schema::create('item_states', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id');

            /**
             * 0: obyčejné počítání (x ks)
             * 1: cca x kusů
             * 2: nepočitatelné
             */
            $table->string('count_type');
            $table->integer('count');

            // Současné místo.
            $table->integer('place_id')->nullable();
            $table->integer('box_id')->nullable();

            /**
             * 0: položka je v zadaném počtu na svém místě
             * 1: položka je vypůjčena (viz data níže)
             * 2: položka byla odepsána uživateli
             */
            $table->integer('state');

            $table->integer('borrower_user_id')->nullable();
            $table->integer('borrower_group_id')->nullable();
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
        Schema::dropIfExists('item_states');
    }
}
