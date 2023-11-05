<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use App\Services\HandleBlogTagService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleBlogTagServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $author;

    private BlogCategory $blogCategory;

    private BlogPost $blogPost;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create(['status' => 'active', 'role' => 'admin']);
        $this->blogCategory = BlogCategory::factory()->create();
        $this->blogPost = BlogPost::factory()->create(['author_id' => $this->author->id, 'blog_category_id' => $this->blogCategory->id]);
    }

    public function test_it_can_handle_tags(): void
    {
        // Arrange
        $tags = ['life', 'sports', 'travel', 'advanture'];

        // Act
        $service = new HandleBlogTagService();
        $service->handle($tags, $this->blogPost);

        // Assert
        $this->assertCount(count($tags), $this->blogPost->blogTags);
        foreach ($tags as $tag) {
            $this->assertContains($tag, $this->blogPost->blogTags->pluck('name')->all());
        }
    }

    public function test_it_does_not_duplicate_existing_tags(): void
    {
        // Arrange
        $tags = ['life', 'sports', 'SPorts', 'travel', 'advanture'];

        // Act
        $service = new HandleBlogTagService();
        $service->handle($tags, $this->blogPost);

        // Assert
        $this->assertCount(4, $this->blogPost->blogTags);
    }
}
