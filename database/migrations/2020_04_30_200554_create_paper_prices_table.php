<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaperPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paper_prices', function (Blueprint $table) {
          $table->id();
          $table->foreignId('paper_prices_set_id');
          $table->foreignId('paper_type_id');
          $table->integer('height');
          $table->integer('width');
          $table->integer('weight');
          $table->foreignId('paper_color_id');
          $table->float('sheet_price', 8, 2);
          $table->timestamps();
          $table->foreign('paper_prices_set_id')->references('id')->on('paper_prices_sets');
          $table->foreign('paper_type_id')->references('id')->on('paper_types');
          $table->foreign('paper_color_id')->references('id')->on('paper_colors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paper_prices');
    }
}
