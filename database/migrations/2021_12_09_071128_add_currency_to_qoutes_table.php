<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyToQoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qoutes', function (Blueprint $table) {
            $table->bigInteger("currency_id")->unsigned()->default(1);
            $table->foreign('currency_id')
            ->references('id')
            ->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qoutes', function (Blueprint $table) {
            $table->dropColumn('currency_id');
        });
    }
}
