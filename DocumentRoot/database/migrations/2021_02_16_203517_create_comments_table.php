<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->comment('User ID (owner) of the comment');
            $table->unsignedBigInteger('product_id')->comment('Product ID of the comment');
            $table->boolean('approve')->default(0)
                ->comment('Comment approval status => 0 for no - 1 for yes');
            $table->text('description')->comment('Content of the comment');
            $table->timestamps();

            $table->index('user_id');
            $table->index('product_id');

            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_general_ci';
        });
    }

    /**users
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
