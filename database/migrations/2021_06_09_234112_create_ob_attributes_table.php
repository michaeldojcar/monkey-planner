<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateObAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ob_attributes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('ob_type_id');
            $table->string('name');
            $table->string('type');
            $table->unsignedInteger('restricted_relation_type_id');
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
        Schema::dropIfExists('ob_attributes');
    }
}
