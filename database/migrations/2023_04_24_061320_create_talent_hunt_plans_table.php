<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTalentHuntPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('talent_hunt_plans', function (Blueprint $table) {
            $table->id('thp_id');
            $table->string('thp_plan');
            $table->decimal('thp_price', 8, 2);
            $table->text('thp_description');
            $table->string('thp_validity');
            $table->integer('thp_movies_qty');
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
        Schema::dropIfExists('talent_hunt_plans');
    }
}
