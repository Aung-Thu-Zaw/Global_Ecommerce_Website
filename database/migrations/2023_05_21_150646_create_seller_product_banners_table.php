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
        Schema::create('seller_product_banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId("seller_id")->references("id")->on("users")->cascadeOnDelete();
            $table->string("image");
            $table->string("url");
            $table->enum("status", ["show","hide"])->default("hide");
            $table->softDeletes();
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
        Schema::dropIfExists('seller_product_banners');
    }
};
