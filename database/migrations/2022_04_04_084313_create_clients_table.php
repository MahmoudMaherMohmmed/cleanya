<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('erp_id')->nullable();
            $table->string('username');
            $table->string('phone')->unique();
			$table->string('email')->nullable()->unique();
            $table->string('password');
			$table->string('image')->nullable();
            $table->bigInteger('city_id')->unsigned()->nullable();
            $table->integer('balance')->default(0);
            $table->integer('type')->default(0)->comment('0=>Client | 1=>Representative');
            $table->integer('status')->default(1)->comment('0=>Not Active | 1=>Active');
            $table->string('activation_code')->nullable();
            $table->string('device_token')->nullable();
			$table->string('remember_token')->nullable();
            $table->timestamps(); 
            $table->softDeletes();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
