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
        Schema::create('chat_file_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('live_chat_message_id')->nullable()->constrained()->cascadeOnDelete();
            $table->enum('type', ['image', 'video', 'file', 'audio']);
            $table->string('attachment_path');
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
        Schema::dropIfExists('chat_file_attachments');
    }
};
