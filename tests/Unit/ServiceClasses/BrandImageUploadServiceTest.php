<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\BrandImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BrandImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('brand-image.jpg');

        // Act
        $service = new BrandImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("brands/$finalName");
    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-brand-image.jpg';
        Storage::put("brands/$existingImageName", 'dummy');
        $newImage = UploadedFile::fake()->image('new-brand-image.jpg');

        // Act
        $service = new BrandImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("brands/$existingImageName");

        // Assert
        Storage::assertExists("brands/$finalName");
        Storage::assertMissing("brands/$existingImageName");
    }
}
