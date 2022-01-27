<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seller_infos', function (Blueprint $table) {
            $table->id();
            $table->string('seller_label')->nullable();
            $table->text('description')->nullable();
            $table->string('seller_level')->nullable();
            $table->string('location')->nullable();
            $table->date('recent_delivery')->nullable();
            $table->foreignId('sub_category_id')->nullable()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('users_id')->unique()->constrained()->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('seller_infos');
    }
}
