<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->enum('type',['offer','request']);
            $table->boolean('is_active')->default(1);
            $table->foreignIdFor(\Modules\HumanService\Entities\ServiceType::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("INSERT INTO `permissions` (`name`, `guard_name`, `category`, `display`)
            VALUES
             ('Index-service' , 'admin', 'Service', 'Index'),
             ('Create-service' , 'admin', 'Service', 'Create'),
             ('Edit-service' , 'admin', 'Service', 'Edit'),
             ('Delete-service' , 'admin', 'Service', 'Delete')
             ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('services');
    }
}
