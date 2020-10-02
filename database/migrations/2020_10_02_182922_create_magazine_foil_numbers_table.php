<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMagazineFoilNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('magazine_foil_numbers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('magazine_job_id');
            $table->foreignId('magazine_unique_paper_id');
            $table->integer('foil_number');
            $table->timestamps();
            $table->foreign('magazine_job_id')->references('id')->on('magazine_jobs');
            $table->foreign('magazine_unique_paper_id')->references('id')->on('magazine_unique_papers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('magazine_foil_numbers');
    }
}
