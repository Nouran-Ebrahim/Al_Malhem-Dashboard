<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSnapYoutubeSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement(
            "INSERT INTO `settings`
             (`id`, `key`, `display`, `value`, `type`)
              VALUES
            (NULL, 'snapchat', 'سناب شات', null,'text'),
            (NULL, 'youtube', 'يوتيوب', null,'text')
"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {

        });
    }
}
