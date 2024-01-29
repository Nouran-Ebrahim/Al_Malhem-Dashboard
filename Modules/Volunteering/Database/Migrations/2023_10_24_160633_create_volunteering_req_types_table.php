<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringReqTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_req_types', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\Modules\Volunteering\Entities\VolunteeringRequest::class)->index()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\Modules\Volunteering\Entities\VolunteeringType::class)->index()->constrained()->cascadeOnDelete();
            // $table->bigInteger('client_id')->unsigned();
            // $table->foreignIdFor(\Modules\Client\Entities\Client::class)->index()->constrained()->cascadeOnDelete();
            // $table->index('volunteering_request_id');
            // $table->index('volunteering_type_id');

            // $table->foreign('volunteering_request_id')->references('id')->on('volunteering_requests')->onDelete('cascade');
            // $table->foreign('volunteering_type_id')->references('id')->on('volunteering_types')->onDelete('cascade');

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
        Schema::dropIfExists('volunteering_requests_volunteerings_types');
    }
}
