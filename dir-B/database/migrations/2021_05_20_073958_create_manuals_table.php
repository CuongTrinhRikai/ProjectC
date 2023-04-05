<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manuals', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('name')->nullable();
            $table->string('manual_id')->nullable();
            $table->unsignedBigInteger('mansion_id')->nullable();
            $table->string('url')->nullable();
            $table->string('filename')->nullable();
            $table->boolean('manual_type')->default(1);
            $table->boolean('flag')->default(1);
            $table->foreign('mansion_id')->references('id')->on('mansions')->onDelete(null);
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
        Schema::dropIfExists('manuals');
    }
}
