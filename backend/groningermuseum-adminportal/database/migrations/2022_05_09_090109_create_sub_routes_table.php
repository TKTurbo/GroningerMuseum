<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('route_id');
            $table->string('name');
            $table->mediumText('description');
            $table->integer('order_number');
            $table->integer('to_next');
            $table->uuid('beacon_uuid');
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
        Schema::dropIfExists('subroutes');
    }
};
