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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId("product_id")->constrained()->cascadeOnDelete();
            $table->foreignId("vendor_id")->references("id")->on("users")->cascadeOnDelete();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->text("review_text");
            $table->integer("rating");
            $table->boolean("status")->default(false);
            $table->timestamps();
        });
    }

//     id (primary key)
// product_id (foreign key referencing the products table)
// user_id (foreign key referencing the users table)
// rating (integer)
// comment (text)
// created_at
// updated_at

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_reviews');
    }
};
