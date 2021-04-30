<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->bigInteger('id_create');
            $table->string('create_by');
            $table->boolean('del_active')->default($value=true);

            $table->string('urlPicture');
            $table->string('title')->nullable();
            $table->string('content')->nullable();
            $table->string('type')->nullable();
            $table->integer('listings')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new__items');
    }
}
