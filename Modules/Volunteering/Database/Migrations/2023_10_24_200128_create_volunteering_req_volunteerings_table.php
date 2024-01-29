<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringReqVolunteeringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_req_volunteerings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Volunteering\Entities\VolunteeringRequest::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Volunteering\Entities\Volunteering::class)->index()->constrained()->cascadeOnDelete();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('volunteering_requests_volunteerings');
    }
}
