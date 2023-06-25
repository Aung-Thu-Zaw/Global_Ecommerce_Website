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
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("blog_category_id")->constrained()->cascadeOnDelete();
            $table->foreignId("author_id")->references("id")->on("users")->cascadeOnDelete();
            $table->string("title");
            $table->string("slug")->unique();
            $table->string("image");
            $table->text("description")->fulltext();
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
        Schema::dropIfExists('blog_posts');
    }
};
