<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categorys')->onUpdate('cascade')->onDelete('cascade');
            $table->string('name');
            $table->float('price');
            $table->string('image');
            $table->string('image2');
            $table->string('image3');
            $table->string('image4');
            $table->integer('quantityM');
            $table->integer('quantityL');
            $table->integer('quantityXL');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
