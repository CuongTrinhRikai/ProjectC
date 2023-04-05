<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnContractorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function listTableForeignKeys($table)
    {
        $conn = Schema::getConnection()->getDoctrineSchemaManager();

        return array_map(function($key) {
            return $key->getName();
        }, $conn->listTableForeignKeys($table));
    }
    public function up()
    {
        Schema::table('contractors', function($table) {
            $foreignKeys = $this->listTableForeignKeys('contractors');
            if(in_array('contractors_sales_staff_foreign', $foreignKeys))
            $table->dropForeign(['sales_staff']);
            if(in_array('contractors_sales_affairs_foreign', $foreignKeys))
            $table->dropForeign(['sales_affairs']);
            if(in_array('contractors_company_general_affairs_foreign', $foreignKeys))
            $table->dropForeign(['company_general_affairs']);

            $table->dropColumn(['sales_affairs']);
            $table->dropColumn(['sales_staff']);
            $table->dropColumn(['company_general_affairs']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contractors', function($table) {
            $table->string('sales_affairs')->nullable();
            $table->string('sales_staff')->nullable();
            $table->string('company_general_affairs')->nullable();

        });
    }
}
