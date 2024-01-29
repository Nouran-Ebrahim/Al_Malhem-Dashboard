<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_types', function (Blueprint $table) {
            $table->id();
            $table->string('color');
            $table->string('title');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
        VALUES
         ('Index-volunteering_type' , 'admin', 'Volunteering Type', 'Index'),
         ('Create-volunteering_type' , 'admin', 'Volunteering Type', 'Create'),
         ('Edit-volunteering_type' , 'admin', 'Volunteering Type', 'Edit'),
         ('Delete-volunteering_type' , 'admin', 'Volunteering Type', 'Delete')
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteering_types');
    }
}