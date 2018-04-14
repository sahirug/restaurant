<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhoneOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phone_orders', function (Blueprint $table) {
            $table->string('order_id');
            $table->date('order_date');
            $table->decimal('tot_cost', 8, 2);
            $table->string('employee_id');
            $table->foreign('employee_id')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->string('branch_id');
            $table->foreign('branch_id')->references('branch_id')->on('branches')->onDelete('cascade');
            $table->string('status');
            $table->string('customer_contact');
            $table->string('rider_id')->nullable();
            $table->foreign('rider_id')->references('employee_id')->on('employees')->onDelete('cascade');
            $table->string('customer_address')->nullable();            
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
        Schema::dropIfExists('phone_orders');
    }
}
