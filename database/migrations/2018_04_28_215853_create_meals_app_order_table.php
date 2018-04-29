<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealsAppOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meals_app_order', function (Blueprint $table) {
            $table->string('meal_id');
            $table->foreign('meal_id')->references('meal_id')->on('meals')->onDelete('cascade');
            $table->string('order_id');
            $table->foreign('order_id')->references('order_id')->on('app_orders')->onDelete('cascade');
            $table->integer('qty');
            $table->timestamps();
            $table->primary(['meal_id', 'order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meals_app_order');
    }
}
