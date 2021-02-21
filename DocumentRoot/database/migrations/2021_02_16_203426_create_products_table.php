<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->comment('Provider ID of the product');
            $table->string('title', 255)->comment('Title of the product');
            $table->unsignedFloat('price')->comment('Price of the product');
            $table->boolean('display')->default(0)->comment('Product display or non-display status');
            $table->boolean('comment')->default(0)
                ->comment('Ability to submit comments => 0 for no - 1 for yes');
            $table->boolean('vote')->default(0)
                ->comment('Ability to submit votes => 0 for no - 1 for yes');
            $table->boolean('buyer_comment_vote')->default(0)
                ->comment('Will only buyers be able to submit comments and votes? => 0 for no - 1 for yes');
            $table->timestamps();

            $table->index('provider_id');

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
        Schema::dropIfExists('products');
    }
}
