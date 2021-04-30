<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('id_create');
            $table->string('create_by');
            $table->boolean('del_active')->default($value=true);

            $table->string('urlLocal');
            $table->string('urlPicture');
            $table->string('namePicture');
            $table->string('titlePicture')->nullable();
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('descreption')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
