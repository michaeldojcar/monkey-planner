<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypesInTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table)
        {
            $table->unsignedInteger('type')->after('name')->default(0);
            $table->unsignedInteger('item_id')->after('type')->nullable();
            $table->unsignedInteger('required_count')->after('item_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table)
        {
            $table->dropColumn('type');
            $table->dropColumn('item_id');
            $table->dropColumn('required_count');
        });
    }
}
