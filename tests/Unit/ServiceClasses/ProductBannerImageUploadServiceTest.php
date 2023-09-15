<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\ProductBannerImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductBannerImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('product-banner-image.jpg');

        // Act
        $service = new ProductBannerImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("product-banners/$finalName");

    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-product-banner-image.jpg';
        Storage::put("product-banners/$existingImageName", "dummy");
        $newImage = UploadedFile::fake()->image('new-product-banner-image.jpg');

        // Act
        $service = new ProductBannerImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("product-banners/$existingImageName");

        // Assert
        Storage::assertExists("product-banners/$finalName");
        Storage::assertMissing("product-banners/$existingImageName");
    }
}
