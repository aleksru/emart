<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('images')->onDelete('cascade');
            $table->string('path')->nullable()->unique();
            $table->unsignedSmallInteger('width')->nullable();
            $table->unsignedSmallInteger('height')->nullable();
            $table->string('modifier')->nullable()->comment('модификатор');
            $table->string('type')->nullable()->comment('тип изображения');
            $table->json('image_attributes')->nullable()->comment('атрибуты изображения, например alt, title и т.п.');
            $table->integer('morph_id')->unsigned()->nullable()->comment('ID полиморфной модели');
            $table->string('morph_type')->nullable()->comment('Тип полиморфной модели');
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
        Schema::dropIfExists('images');
    }
}
