<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID (owner) of the vote');
            $table->unsignedBigInteger('product_id')->comment('Product ID of the vote');
            $table->boolean('approve')->default(0)
                ->comment('Vote approval status => 0 for no - 1 for yes');
            $table->unsignedTinyInteger('vote')->default(5)
                ->comment('Vote of the comment => from 1 to 5');
            $table->timestamps();

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
