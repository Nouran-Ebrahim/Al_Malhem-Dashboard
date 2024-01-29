<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOccasionsCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occasions_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('color')->default('#FFFFFF');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-occasions_category' , 'admin', 'Occasions Category', 'Index'),
             ('Create-occasions_category' , 'admin', 'Occasions Category', 'Create'),
             ('Edit-occasions_category' , 'admin', 'Occasions Category', 'Edit'),
             ('Delete-occasions_category' , 'admin', 'Occasions Category', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('occasions_categories');
    }
}
