<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagazineUniquePapersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magazine_unique_papers', function (Blueprint $table) {
          $table->id();
          $table->foreignId('magazine_job_id');
          $table->foreignId('paper_price_id');
          $table->float('leaf_width',8,2);
          $table->float('leaf_height',8,2);
          $table->integer('leaf_width_qty');
          $table->integer('leaf_height_qty');
          $table->integer('pose_width_qty');
          $table->integer('pose_height_qty');
          $table->string('position', 100);
          $table->string('front_back', 100);

          $table->string('front_machine', 100);
          $table->string('back_machine', 100);
          $table->integer('front_color_qty');
          $table->integer('back_color_qty');

          $table->integer('front_pantone')->nullable()->default(NULL);
          $table->integer('back_pantone')->nullable()->default(NULL);
          $table->timestamps();
          $table->foreign('paper_price_id')->references('id')->on('paper_prices');
          $table->foreign('magazine_job_id')->references('id')->on('magazine_jobs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazine_unique_papers');
    }
}
