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
        Schema::create('live_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId("live_chat_id")->constrained()->cascadeOnDelete();
            $table->foreignId("user_id")->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId("agent_id")->nullable()->references("id")->on("users")->cascadeOnDelete();
            $table->text("message")->nullable();
            $table->boolean("is_read_by_user")->default(false);
            $table->boolean("is_read_by_agent")->default(false);
            $table->boolean("is_deleted_by_user")->default(false);
            $table->boolean("is_deleted_by_agent")->default(false);
            $table->boolean("pinned")->default(false);
            $table->boolean("is_edited")->default(false);
            $table->integer("reply_to_message_id")->nullable();
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
        Schema::dropIfExists('live_chat_messages');
    }
};
