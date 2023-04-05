<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMansionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mansions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('mansion_id')->nullable();
            $table->string('mansion_name')->nullable();
            $table->string('address')->nullable();
            $table->string('mansion_phone')->nullable();
            $table->float('latitude')->nullable();
            $table->float('longitude')->nullable();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->foreign('instructor_id')->references('id')->on('guides');
            $table->unsignedBigInteger('contractor_id');
            $table->foreign('contractor_id')->references('id')->on('contractors');
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
        Schema::dropIfExists('mansions');
    }
}
