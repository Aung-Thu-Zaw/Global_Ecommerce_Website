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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('vendor_id')->references("id")->on("users")->cascadeOnDelete();
            $table->string("color")->nullable();
            $table->string("size")->nullable();
            $table->integer("qty");
            $table->date('return_date')->nullable();
            $table->text('return_reason')->nullable();
            $table->enum('return_status', ["pending","approved","refunded"])->nullable();
            $table->date('return_approved_date')->nullable();
            $table->date('return_refunded_date')->nullable();
            $table->decimal('price', 8, 2);
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
        Schema::dropIfExists('order_items');
    }
};
