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
        Schema::table('product_questions', function (Blueprint $table) {
            $table->foreignId("shop_id")->after("product_id")->references("id")->on("products")->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_questions', function (Blueprint $table) {
            $table->dropConstrainedForeignId("shop_id");
        });
    }
};
