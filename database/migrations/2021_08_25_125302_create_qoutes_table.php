<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qoutes', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->id();
			$table->bigInteger("user_id")->unsigned();
			$table->string("name",128)->unique();
			$table->text("note");
			$table->bigInteger("curr_vr_id");
            $table->timestamps();
			$table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('qoutes');
    }
}
