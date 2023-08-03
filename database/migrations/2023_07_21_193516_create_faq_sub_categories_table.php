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
        Schema::create('faq_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("faq_category_id")->constrained()->cascadeOnDelete();
            $table->string("icon")->nullable();
            $table->string("name")->unique();
            $table->string("slug")->unique();
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
        Schema::dropIfExists('faq_sub_categories');
    }
};
