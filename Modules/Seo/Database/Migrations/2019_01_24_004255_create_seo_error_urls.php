<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeoErrorUrls extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seo_error_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->text('url')->comment('URL, на котором произошла ошибка');
            $table->text('referer')->nullable();
            $table->string('user_agent')->nullable();
            $table->smallInteger('status_code')->nullable()->comment('HTTP код ошибки');
            $table->longText('message')->nullable();
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
        Schema::dropIfExists('seo_error_urls');
    }
}
