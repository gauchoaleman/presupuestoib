<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagazineJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magazine_jobs', function (Blueprint $table) {
          $table->id();
          $table->integer('pose_width');
          $table->integer('pose_height');
          $table->integer('copy_qty');
          $table->integer('page_qty');
          $table->string('finishing', 255);
          $table->integer('machine_washing_qty')->nullable()->default(NULL);
          $table->string('mounting', 255);
          $table->float('shipping',18,13);
          $table->integer('discount_percentage');
          $table->integer('plus_percentage');
          $table->foreignId('client_id');
          $table->string('budget_name', 255);
          $table->foreignId('dollar_price_id');
          $table->timestamps();
          $table->foreign('client_id')->references('id')->on('clients');
          $table->foreign('dollar_price_id')->references('id')->on('dollar_prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazine_jobs');
    }
}
