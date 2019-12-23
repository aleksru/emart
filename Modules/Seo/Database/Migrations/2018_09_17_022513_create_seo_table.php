<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('header')->nullable()->comment('SEO для заголовка H1 на странице');
            $table->string('header_2')->nullable()->comment('SEO для заголовка H2 на странице');
            $table->string('title')->nullable()->comment('SEO для заголовка страницы в браузере');
            $table->string('keywords')->nullable()->comment('SEO для meta keywords');
            $table->text('description')->nullable()->comment('SEO для meta description');
            $table->json('content')->nullable()->comment('Дополнительные SEO контент, который не вписывается в стандартные рамки');
            
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
        Schema::dropIfExists('seo');
    }
}
