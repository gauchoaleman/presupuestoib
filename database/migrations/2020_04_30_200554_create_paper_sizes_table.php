<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_sizes', function (Blueprint $table) {
          $table->id();
          $table->foreignId('paper_sizes_set_id');
          $table->integer('sheet_width');
          $table->integer('sheet_height');
          $table->integer('leaf_width');
          $table->integer('leaf_height');
          $table->integer('leaf_qty_per_sheet');
          $table->timestamps();
          $table->foreign('paper_sizes_set_id')->references('id')->on('paper_sizes_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_sizes');
    }
}
