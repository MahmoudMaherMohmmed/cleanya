<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('description');
            $table->text('working_days');
            $table->text('from');
            $table->text('to');
            $table->float('tax', 8,2)->default(0);
            $table->string('email_1');
            $table->string('email_2');
            $table->string('phone_1');
            $table->string('phone_2');
            $table->text('facebook_link');
            $table->text('whatsapp_link')->nullable();
            $table->text('twitter_link')-> nullable();
            $table->text('instagram_link')->nullable();
            $table->text('snapchat_link')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('tiktok_link')->nullable();
            $table->string('api_url')->nullable();
            $table->string('api_key')->nullable();
            $table->string('api_username')->nullable();
            $table->string('api_password')->nullable();
            $table->integer('soft_opening')->default(1)->comment('0=>unactive | 1=>active');
            $table->string('lat');
            $table->string('lng');
            $table->string('logo'); 
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
        Schema::dropIfExists('applications');
    }
}
