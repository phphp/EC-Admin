<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBannerImageTable extends Migration
{

    public function up()
    {
        Schema::create('banner_image', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('banner_id')->unsigned();
            $table->integer('image_id')->unsigned();
            $table->integer('item_type')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('sort')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('banner_image');
    }

}
