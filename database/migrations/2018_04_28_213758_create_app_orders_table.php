<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_orders', function (Blueprint $table) {
            $table->string('order_id');
            $table->date('order_date');
            $table->decimal('tot_cost', 8, 2);
            $table->integer('app_user_id')->unsigned();
            $table->foreign('app_user_id')->references('id')->on('app_users')->onDelete('cascade');;
            $table->string('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->string('status');
            $table->string('rider')->nullable();
            $table->foreign('rider')->references('employee_id')->on('employees')->onDelete('cascade');            
            $table->string('lat');
            $table->string('lng');
            $table->primary('order_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_orders');
    }
}
