<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\BlogCategoryImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BlogCategoryImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('blog-category-image.jpg');

        // Act
        $service = new BlogCategoryImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("blog-categories/$finalName");
        // $this->assertFileExists(storage_path('app/public/blog-categories/') . $finalName);
    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-blog-category-image.jpg';
        Storage::put("blog-categories/$existingImageName", 'dummy');
        $newImage = UploadedFile::fake()->image('new-blog-category-image.jpg');

        // Act
        $service = new BlogCategoryImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("blog-categories/$existingImageName");

        // Assert
        Storage::assertExists("blog-categories/$finalName");
        Storage::assertMissing("blog-categories/$existingImageName");
    }
}
