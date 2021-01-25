<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->integer('customer_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('service_id')->unsigned();
            $table->float('amount');
            $table->string('branch')->nullable();
            $table->dateTime('from_at');
            $table->dateTime('to_at');
            $table->string('size')->nullable();
            $table->string('address');
            $table->string('pincode', 10);
            $table->string('description')->nullable();
            $table->integer('phone_number');
            $table->string('image')->nullable();
            $table->string('hospital_doc')->nullable();
            $table->string('parent_proof')->nullable();
            $table->string('name', 50)->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('status', 50)->default('requested');
            $table->softDeletes();
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
        Schema::dropIfExists('service_orders');
    }
}
