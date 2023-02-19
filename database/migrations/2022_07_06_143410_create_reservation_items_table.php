<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reservation_id')->unsigned();
            $table->bigInteger('service_id')->unsigned();
            $table->bigInteger('cloth_id')->unsigned();
            $table->float('piece_cost', 8, 2)->default(0);
            $table->integer('pieces_number')->default(0);
            $table->float('cost', 8, 2)->default(0);
            $table->timestamps();

            $table->foreign('reservation_id')->references('id')->on('reservations')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('cloth_id')->references('id')->on('clothes')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservation_items');
    }
}
