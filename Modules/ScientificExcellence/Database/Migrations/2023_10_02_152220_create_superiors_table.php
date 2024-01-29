<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuperiorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('superiors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('gender', ['female', 'male']);
            $table->string('civil');
            $table->string('year');
            $table->string('specialization');
            $table->string('gpa');
            $table->string('phone');
            $table->string('parent_phone');
            $table->string('certification');
            $table->string('personal')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignIdFor(\Modules\ScientificExcellence\Entities\Party::class)->nullable()->index()->constrained()->cascadeOnDelete();
            // $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
        VALUES
         ('Index-superior' , 'admin', 'Superior', 'Index'),
         ('Create-superior' , 'admin', 'Superior', 'Create'),
         ('Edit-superior' , 'admin', 'Superior', 'Edit'),
         ('Delete-superior' , 'admin', 'Superior', 'Delete')
         ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('superiors');
    }
}