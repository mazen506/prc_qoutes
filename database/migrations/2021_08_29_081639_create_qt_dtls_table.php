<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQtDtlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qt_items', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
			$table->bigInteger('qoute_id')->unsigned();
			$table->string('item_name');
			$table->bigInteger('unit_id')->unsigned();
			$table->integer('package_qty');
            $table->bigInteger('package_unit_id')->unsigned();
			$table->decimal('price',8,2);
			$table->integer('moq')->nullable();
			$table->text('note')->nullable();
            $table->timestamps();
			$table->foreign('qoute_id')
                ->references('id')
                ->on('qoutes')
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
        Schema::dropIfExists('qt_items');
    }
}
