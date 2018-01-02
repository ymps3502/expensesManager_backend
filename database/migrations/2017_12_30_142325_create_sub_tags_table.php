<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtags', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name', 10);
            $table->unsignedSmallInteger('tag_id');
            // $table->unsignedInteger('bill_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subtags');
    }
}
