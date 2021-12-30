<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGigGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gig_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('image1_location');
            $table->string('image2_location')->nullable();
            $table->string('image3_location')->nullable();
            $table->string('video_location')->nullable();
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
        Schema::dropIfExists('gig_galleries');
    }
}
