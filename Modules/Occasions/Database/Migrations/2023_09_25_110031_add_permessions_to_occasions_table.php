<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermessionsToOccasionsTable extends Migration
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
             ('Index-occasions' , 'admin', 'Occasion', 'Index'),
             ('Create-occasions' , 'admin', 'Occasion', 'Create'),
             ('Edit-occasions' , 'admin', 'Occasion', 'Edit'),
             ('Delete-occasions' , 'admin', 'Occasion', 'Delete')
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
