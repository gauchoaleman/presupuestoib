<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeafSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaf_sizes', function (Blueprint $table) {
          $table->id();
          $table->foreignId('leaf_sizes_set_id');
          $table->integer('sheet_width');
          $table->integer('sheet_height');
          $table->integer('leaf_width');
          $table->integer('leaf_height');
          $table->integer('leaf_qty_per_sheet');
          $table->timestamps();
          $table->foreign('leaf_sizes_set_id')->references('id')->on('leaf_sizes_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leaf_sizes');
    }
}
