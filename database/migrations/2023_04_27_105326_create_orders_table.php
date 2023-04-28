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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('shipping_address');
            $table->string('billing_address');
            $table->text('note');
            $table->string('payment_type');
            $table->string('payment_method');
            $table->string('currency')->default('usd');
            $table->string('transaction_id');
            $table->decimal('total_amount', 8, 2);
            $table->string('order_no');
            $table->string('invoice_no');
            $table->date('order_date');
            $table->date('confirmed_date');
            $table->date('processing_date');
            $table->date('picked_date');
            $table->date('shipped_date');
            $table->date('delivered_date');
            $table->date('cancel_date');
            $table->date('return_date');
            $table->string('status')->default('new');
            $table->text('return_reason');
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
