<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPackagesidToQtdtlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qt_items', function (Blueprint $table) {
            	$table->foreign('unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('cascade');
                $table->foreign('package_unit_id')
                ->references('id')
                ->on('units')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qt_items', function (Blueprint $table) {
            //
        });
    }
}
