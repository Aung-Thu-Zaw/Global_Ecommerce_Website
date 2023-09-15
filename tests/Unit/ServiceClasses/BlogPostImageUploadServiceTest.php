<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\BlogPostImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogPostImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('blog-post-image.jpg');

        // Act
        $service = new BlogPostImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("blog-posts/$finalName");

    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-blog-post-image.jpg';
        Storage::put("blog-posts/$existingImageName", "dummy");
        $newImage = UploadedFile::fake()->image('new-blog-post-image.jpg');

        // Act
        $service = new BlogPostImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("blog-posts/$existingImageName");

        // Assert
        Storage::assertExists("blog-posts/$finalName");
        Storage::assertMissing("blog-posts/$existingImageName");
    }
}
