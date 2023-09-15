<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\ProductImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('product-image.jpg');

        // Act
        $service = new ProductImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("products/$finalName");

    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-product-image.jpg';
        Storage::put("products/$existingImageName", "dummy");
        $newImage = UploadedFile::fake()->image('new-product-image.jpg');

        // Act
        $service = new ProductImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("products/$existingImageName");

        // Assert
        Storage::assertExists("products/$finalName");
        Storage::assertMissing("products/$existingImageName");
    }
}
