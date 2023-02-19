<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id')->unsigned();
            $table->bigInteger('representative_id')->unsigned()->nullable();
            $table->bigInteger('reception_address_id')->unsigned()->nullable();
            $table->date('reception_date')->nullable();
            $table->string('reception_time')->nullable();
            $table->bigInteger('sending_address_id')->unsigned()->nullable();
            $table->date('sending_date')->nullable();
            $table->string('sending_time')->nullable();
            $table->float('delivery_cost', 8,2)->default(0);
            $table->float('pieces_price', 8, 2)->default(0);
            $table->string('coupon')->nullable();
            $table->integer('discount')->nullable();
            $table->float('price_after_discount', 8, 2)->nullable();
            $table->float('tax', 8,2)->default(0);
            $table->float('tax_amount', 8,2)->default(0);
            $table->float('total_price', 8, 2)->default(0);
            $table->integer('payment_type')->default(0)->comment('0=>cash | 1=>Balance | 3=>online');
            $table->text('transaction_id')->nullable();
            $table->integer('client_approve')->default(0)->comment('0=>No | 1=>Yes');
            $table->integer('status')->default(1)->comment('0=>Cancelled | 1=>Pending | 2=>InReceive | 3=>Received | 4=>Washing | 5=>InDelivery | 6=>Delivered');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('client_id')->references('id')->on('clients')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('representative_id')->references('id')->on('clients')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('reception_address_id')->references('id')->on('addresses')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('sending_address_id')->references('id')->on('addresses')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
