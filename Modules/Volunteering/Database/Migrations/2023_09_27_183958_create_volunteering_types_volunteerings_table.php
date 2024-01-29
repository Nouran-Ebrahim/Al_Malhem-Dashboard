<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringTypesVolunteeringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_types_volunteerings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Volunteering\Entities\Volunteering::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Volunteering\Entities\VolunteeringType::class)->index()->constrained()->cascadeOnDelete();
            // $table->bigInteger('client_id')->unsigned();
            $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteering_types_volunteerings');
    }
}
