<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date("date");
            $table->string('file')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-party' , 'admin', 'Party', 'Index'),
             ('Create-party' , 'admin', 'Party', 'Create'),
             ('Edit-party' , 'admin', 'Party', 'Edit'),
             ('Delete-party' , 'admin', 'Party', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parties');
    }
}
