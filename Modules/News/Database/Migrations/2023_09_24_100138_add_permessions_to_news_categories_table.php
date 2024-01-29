<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermessionsToNewsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-news_category' , 'admin', 'News Category', 'Index'),
             ('Create-news_category' , 'admin', 'News Category', 'Create'),
             ('Edit-news_category' , 'admin', 'News Category', 'Edit'),
             ('Delete-news_category' , 'admin', 'News Category', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {

        });
    }
}
