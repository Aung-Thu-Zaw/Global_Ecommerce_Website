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
        Schema::table('shop_reviews', function (Blueprint $table) {
            $table->enum("status", ["pending","published","unpublished"])->after("rating")->default("pending");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_reviews', function (Blueprint $table) {
            $table->dropColumn("status");
        });
    }
};
