<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('company_name')->nullable();
            $table->string('contractorId')->nullable();
            $table->unsignedBigInteger('sales_staff')->nullable();
            $table->unsignedBigInteger('sales_affairs')->nullable();
            $table->unsignedBigInteger('company_general_affairs')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('sales_staff')->references('id')->on('guides');
            $table->foreign('sales_affairs')->references('id')->on('guides');
            $table->foreign('company_general_affairs')->references('id')->on('guides');
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
        Schema::dropIfExists('contractors');
    }
}
