<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_settings', function (Blueprint $table) {
            $table->id();
            $table->string("logo")->nullable();
            $table->string("favicon")->nullable();
            $table->string("phone")->nullable();
            $table->string("support_phone")->nullable();
            $table->ema("email")->nullable();
            $table->string("company_address")->nullable();
            $table->string("copyright")->nullable();
            $table->string("youtube")->nullable();
            $table->string("facebook")->nullable();
            $table->string("twitter")->nullable();
            $table->string("instagram")->nullable();
            $table->string("reddit")->nullable();
            $table->string("linked_in")->nullable();
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
        Schema::dropIfExists('website_settings');
    }
};
