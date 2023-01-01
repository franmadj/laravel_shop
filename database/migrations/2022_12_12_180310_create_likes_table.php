<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::disableForeignKeyConstraints();

		Schema::create('likes', function(Blueprint $table)
		{
			$table->id();
			$table->foreignId('user_id')->constrained()->onDelete('cascade');
			$table->morphs('likable');
			$table->unique(['user_id', 'likable_id', 'likable_type']);
			$table->timestamps();
		});

		Schema::disableForeignKeyConstraints();
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('likes');
	}

}
