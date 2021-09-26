<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('id_create');
            $table->string('create_by');
            $table->boolean('del_active')->default($value=true);

            $table->boolean('status')->default($value=true);
            $table->string('urlPicture');
            $table->string('ulrLocal');
            $table->string('namePicture');
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('descreption')->nullable();
            $table->string('titlePicture')->nullable();
            $table->string('type')->nullable();
            $table->string('address')->nullable();
            $table->string('slud')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
