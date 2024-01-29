<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiceTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_types', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('color');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-service_type' , 'admin', 'Service Type', 'Index'),
             ('Create-service_type' , 'admin', 'Service Type', 'Create'),
             ('Edit-service_type' , 'admin', 'Service Type', 'Edit'),
             ('Delete-service_type' , 'admin', 'Service Type', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_types');
    }
}
