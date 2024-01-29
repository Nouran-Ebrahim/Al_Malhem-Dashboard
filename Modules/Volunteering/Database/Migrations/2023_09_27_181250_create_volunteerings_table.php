<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteerings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('details');
            $table->enum('gender',['male','female']);
            $table->boolean('is_active')->default(1);
            $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-volunteering' , 'admin', 'Volunteering', 'Index'),
             ('Create-volunteering' , 'admin', 'Volunteering', 'Create'),
             ('Edit-volunteering' , 'admin', 'Volunteering', 'Edit'),
             ('Delete-volunteering' , 'admin', 'Volunteering', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteerings');
    }
}
