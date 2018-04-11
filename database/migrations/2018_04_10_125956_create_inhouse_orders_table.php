<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInhouseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inhouse_orders', function (Blueprint $table) {
            $table->string('order_id')->unique();
            $table->date('order_date');
            $table->decimal('tot_cost', 8, 2);
            $table->string('employee_id');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->string('table_id');
            $table->foreign('table_id')->references('table_id')->on('tables')->onDelete('cascade');
            $table->string('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['order_id', 'branch_id']);
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
        Schema::dropIfExists('inhouse_orders');
    }
}
