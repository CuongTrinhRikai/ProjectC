<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->nullable();
            $table->string('native_name')->nullable();
            $table->string('alpha_code')->nullable();
            $table->string('alpha_code_3')->nullable();
            $table->json('alternate_spellings')->nullable();
            $table->json('calling_codes')->nullable();
            $table->json('currencies')->nullable();
            $table->json('languages')->nullable();
            $table->string('flag')->nullable();
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
        Schema::dropIfExists('countries');
    }
}
