<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_template_translations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('email_template_id')->unsigned();
            $table->string('language_code');
            $table->string('subject')->nullable();
            $table->text('template', 'longtext')->nullable();
            $table->foreign('email_template_id')->references('id')->on('email_templates')->onDelete('cascade');
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
        Schema::dropIfExists('email_template_translations');
    }
}
