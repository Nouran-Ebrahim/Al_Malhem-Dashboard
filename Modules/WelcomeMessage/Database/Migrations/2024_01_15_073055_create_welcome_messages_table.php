<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWelcomeMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('welcome_messages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_active')->default(1);
            $table->string('image');
            $table->string('description');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
        VALUES
         ('Index-welcome_message' , 'admin', 'Welcome Masseges', 'Index'),
         ('Create-welcome_message' , 'admin', 'Welcome Masseges', 'Create'),
         ('Edit-welcome_message' , 'admin', 'Welcome Masseges', 'Edit'),
         ('Delete-welcome_message' , 'admin', 'Welcome Masseges', 'Delete')
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('welcome_messages');
    }
}
