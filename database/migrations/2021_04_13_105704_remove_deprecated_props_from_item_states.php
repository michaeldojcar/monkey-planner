<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveDeprecatedPropsFromItemStates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('item_states', function (Blueprint $table)
        {
            $table->dropColumn('count_type');
            $table->dropColumn('box_id');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('item_states', function (Blueprint $table)
        {
            $table->string('count_type');
            $table->integer('box_id')->nullable();
        });
    }
}
