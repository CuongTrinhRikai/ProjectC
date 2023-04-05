<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuildingAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('building_admins', function (Blueprint $table) {
            $table->id();
            $table->uuid('account_id')->nullable();
            $table->string('name');
            $table->string('username')->unique()->nullable(false);
            $table->string('email')->unique()->nullable();
            $table->bigInteger('contractor_id')->unsigned();
            $table->enum('business_category', ['Cleaning', 'Management', 'Cleaning Management', 'Night Management', 'Patrol Cleaning', 'Patrol Management', 'Residence Management', 'Concierge Business']);
            $table->string('password')->nullable();
            $table->boolean('Password_resetted')->default(0);
            $table->foreign('contractor_id')->references('id')->on('contractors')->onDelete(null);
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
        Schema::dropIfExists('building_admins');
    }
}
