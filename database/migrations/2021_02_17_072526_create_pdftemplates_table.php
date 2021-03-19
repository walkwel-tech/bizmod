<?php

use App\PdfTemplate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdftemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdf_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('slug');
            $table->text('description')->nullable();
            $table->enum('type', PdfTemplate::getAvailableTypesValues()->toArray());
            $table->string('path');
            $table->integer('business_id')->unsigned()->nullable();
            $table->text('configuration')->nullable();
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
        Schema::dropIfExists('pdf_templates');
    }
}
