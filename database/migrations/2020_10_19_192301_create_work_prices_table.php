<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_prices', function (Blueprint $table) {
          $table->id();
          $table->foreignId('work_prices_set_id');
          $table->string('name', 100);
          $table->float('price', 8, 2);
          $table->timestamps();
          $table->foreign('work_prices_set_id')->references('id')->on('work_prices_sets');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_prices');
    }
}
