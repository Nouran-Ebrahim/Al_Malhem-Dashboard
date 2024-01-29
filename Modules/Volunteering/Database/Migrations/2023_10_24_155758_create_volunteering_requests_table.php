<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date("date");
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-volunteering_request' , 'admin', 'Volunteering Request', 'Index'),
             ('Create-volunteering_request' , 'admin', 'Volunteering Request', 'Create'),
             ('Edit-volunteering_request' , 'admin', 'Volunteering Request', 'Edit'),
             ('Delete-volunteering_request' , 'admin', 'Volunteering Request', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteering_requests');
    }
}
