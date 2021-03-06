<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no', 8);
            $table->string('code', 12);
            $table->string('description')->nullable();
            $table->integer('business_id')->unsigned();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('digital_template_id')->unsigned()->nullable();
            $table->integer('print_ready_template_id')->unsigned()->nullable();
            $table->text('claim_details')->nullable();
            $table->timestamp('claimed_on')->nullable();
            $table->timestamp('given_on')->nullable();
            $table->timestamp('expire_on')->useCurrent();
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
        Schema::dropIfExists('codes');
    }
}
