<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{

    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->nullable();
            $table->string('alt')->nullable();
            $table->unsignedTinyInteger('internal')->default(1);
            $table->string('src');
            $table->string('mime_type', 100)->nullable();
            $table->unsignedInteger('width')->nullable();
            $table->unsignedInteger('height')->nullable();
            $table->unsignedBigInteger('filesize')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }

}
