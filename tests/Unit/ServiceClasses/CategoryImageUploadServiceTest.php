<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\CategoryImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CategoryImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('category-image.jpg');

        // Act
        $service = new CategoryImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("categories/$finalName");
    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-category-image.jpg';
        Storage::put("categories/$existingImageName", 'dummy');
        $newImage = UploadedFile::fake()->image('new-category-image.jpg');

        // Act
        $service = new CategoryImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("categories/$existingImageName");

        // Assert
        Storage::assertExists("categories/$finalName");
        Storage::assertMissing("categories/$existingImageName");
    }
}
