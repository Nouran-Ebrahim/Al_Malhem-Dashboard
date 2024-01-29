<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropClientIdFromVolunteeringTypesVolunteeringsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('volunteering_types_volunteerings', function (Blueprint $table) {
            $table->dropForeign('volunteering_types_volunteerings_client_id_foreign');
            $table->dropColumn('client_id');

        });
    }


}
