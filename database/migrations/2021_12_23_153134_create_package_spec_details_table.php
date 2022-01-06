<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageSpecDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_spec_details', function (Blueprint $table) {
            $table->id();
            // title of the table
            $table->string('spec');
            $table->string('package_spec_detail_value');
            $table->foreignId('package_spec_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnUpdate()->cascadeOnDelete();
            $table->unique(['package_spec_id', "package_id"]);
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
        Schema::dropIfExists('package_spec_details');
    }
}
