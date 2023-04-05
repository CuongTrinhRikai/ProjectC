<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnsMansionTable extends Migration
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
        Schema::table('mansions', function($table) {
            $foreignKeys = $this->listTableForeignKeys('mansions');
            if(in_array('mansions_instructor_id_foreign', $foreignKeys))
            $table->dropForeign(['instructor_id']);

            $table->dropColumn(['instructor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::table('mansions', function($table) {
            $table->string('instructor_id')->nullable();

        });
    }
}
