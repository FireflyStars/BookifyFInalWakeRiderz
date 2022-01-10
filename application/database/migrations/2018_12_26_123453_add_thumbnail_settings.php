<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThumbnailSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('category_thumbnail_width')->default('400');
            $table->string('category_thumbnail_height')->default('400');
            $table->string('package_thumbnail_width')->default('500');
            $table->string('package_thumbnail_height')->default('300');
            $table->string('addon_thumbnail_width')->default('500');
            $table->string('addon_thumbnail_height')->default('300');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('category_thumbnail_width');
            $table->dropColumn('category_thumbnail_height');
            $table->dropColumn('package_thumbnail_width');
            $table->dropColumn('package_thumbnail_height');
            $table->dropColumn('addon_thumbnail_width');
            $table->dropColumn('addon_thumbnail_height');
        });
    }
}
