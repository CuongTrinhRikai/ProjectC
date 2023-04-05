<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingAdminMansionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_admin_mansions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('building_admin_id')->unsigned();
            $table->bigInteger('mansion_id')->unsigned();
            $table->foreign('building_admin_id')->references('id')->on('building_admins')->onDelete('cascade');
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
        Schema::dropIfExists('building_admin_mansions');
    }
}
