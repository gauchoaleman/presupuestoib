<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paper_price_id');
            $table->float('leaf_width',8,2);
            $table->float('leaf_height',8,2);
            $table->integer('leaf_width_qty');
            $table->integer('leaf_height_qty');
            $table->integer('pose_width_qty');
            $table->integer('pose_height_qty');
            $table->string('position', 100);
            $table->string('front_back', 100);
            $table->integer('pose_width');
            $table->integer('pose_height');
            $table->integer('copy_qty');
            $table->string('machine', 100);
            $table->integer('front_color_qty');
            $table->integer('back_color_qty');
            $table->integer('pantone_1')->nullable()->default(NULL);
            $table->integer('pantone_2')->nullable()->default(NULL);
            $table->integer('pantone_3')->nullable()->default(NULL);
            $table->integer('pose_qty')->nullable()->default(NULL);
            $table->integer('fold_qty')->nullable()->default(NULL);
            $table->integer('punching_difficulty')->nullable()->default(NULL);
            $table->boolean('perforate');
            $table->boolean('tracing');
            $table->boolean('lac');
            $table->float('various_finishing',18,13);
            $table->float('mounting',18,13);
            $table->float('shipping',18,13);
            $table->integer('discount_percentage');
            $table->integer('plus_percentage');
            $table->foreignId('client_id');
            $table->string('budget_name', 255);
            $table->foreignId('dollar_price_id');
            $table->timestamps();
            $table->foreign('paper_price_id')->references('id')->on('paper_prices');
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
        Schema::dropIfExists('common_jobs');
    }
}
