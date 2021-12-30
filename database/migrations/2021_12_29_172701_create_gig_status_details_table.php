<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigStatusDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_status_details', function (Blueprint $table) {
            $table->id();
            $table->string('message')->nullable();
            $table->foreignId('gig_status_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gig_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('gig_status_details');
    }
}
