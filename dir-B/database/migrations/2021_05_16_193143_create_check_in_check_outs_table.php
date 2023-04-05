<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckInCheckOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_in_check_outs', function (Blueprint $table) {
                $table->id();
                $table->bigInteger('building_admin_id')->unsigned();
                $table->bigInteger('mansion_id')->unsigned();
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->string('token')->nullable();
                $table->string('check_in')->nullable();
                $table->string('check_out')->nullable();
                $table->foreign('mansion_id')->references('id')->on('mansions')->onDelete(null);
                $table->foreign('building_admin_id')->references('id')->on('building_admins')->onDelete(null);


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
        Schema::dropIfExists('check_in_check_outs');
    }
}
