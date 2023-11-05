<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('delivery_information_id')->references('id')->on('delivery_information');
            $table->string('payment_id')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('transaction_id')->nullable();
            $table->string('currency')->default('usd');
            $table->decimal('total_amount', 8, 2);
            $table->string('order_no')->nullable();
            $table->string('invoice_no');
            $table->date('order_date');
            $table->date('confirmed_date')->nullable();
            $table->date('processing_date')->nullable();
            $table->date('shipped_date')->nullable();
            $table->date('delivered_date')->nullable();
            $table->enum('order_status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered']);
            $table->date('return_date')->nullable();
            $table->text('return_reason')->nullable();
            $table->enum('return_status', ['requested', 'approved', 'refunded'])->nullable();
            $table->date('return_approved_date')->nullable();
            $table->date('return_refunded_date')->nullable();
            $table->date('cancel_date')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->enum('cancel_status', ['requested', 'approved'])->nullable();
            $table->date('cancel_approved_date')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
