<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsCalendersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_calenders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->boolean('is_active')->default(1);
            $table->date('date');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
        VALUES
         ('Index-calender' , 'admin', 'Calender ', 'Index'),
         ('Create-calender' , 'admin', 'Calender ', 'Create'),
         ('Edit-calender' , 'admin', 'Calender ', 'Edit'),
         ('Delete-calender' , 'admin', 'Calender ', 'Delete')
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_calenders');
    }
}
