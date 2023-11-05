<?php

namespace Database\Seeders;

use App\Models\BlogCommentReply;
use Illuminate\Database\Seeder;

class BlogCommentReplySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogCommentReply::factory(300)->create();
    }
}
