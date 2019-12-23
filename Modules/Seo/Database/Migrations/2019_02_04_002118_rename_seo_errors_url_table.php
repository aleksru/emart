<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameSeoErrorsUrlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('seo_error_urls', 'seo_not_found_pages');
        Schema::table('seo_not_found_pages', function (Blueprint $table) {
            $table->dropColumn('status_code');
            $table->dropColumn('message');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('seo_not_found_pages', 'seo_error_urls');
        Schema::table('seo_error_urls', function (Blueprint $table) {
            $table->smallInteger('status_code')->nullable()->comment('HTTP код ошибки');
            $table->longText('message')->nullable();
        });
    }
}
