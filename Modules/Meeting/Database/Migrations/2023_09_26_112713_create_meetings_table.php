<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_active');
            $table->string('title');
            $table->text('description');
            $table->string('lat');
            $table->string('long');
            $table->string('phone');
            $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-meeting' , 'admin', 'Meeting', 'Index'),
             ('Create-meeting' , 'admin', 'Meeting', 'Create'),
             ('Edit-meeting' , 'admin', 'Meeting', 'Edit'),
             ('Delete-meeting' , 'admin', 'Meeting', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meetings');
    }
}
