<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMealOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meal_order', function (Blueprint $table) {
            $table->string('meal_id');
            $table->foreign('meal_id')->references('meal_id')->on('meals')->onDelete('cascade');
            $table->string('order_id');
            $table->foreign('order_id')->references('order_id')->on('inhouse_orders')->onDelete('cascade');
            $table->integer('qty');
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('meal_order');
    }
}
