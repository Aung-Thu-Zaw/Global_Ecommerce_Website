<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\SliderBannerImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SliderBannerImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('slider-banner-image.jpg');

        // Act
        $service = new SliderBannerImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("slider-banners/$finalName");

    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-slider-banner-image.jpg';
        Storage::put("slider-banners/$existingImageName", "dummy");
        $newImage = UploadedFile::fake()->image('new-slider-banner-image.jpg');

        // Act
        $service = new SliderBannerImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("slider-banners/$existingImageName");

        // Assert
        Storage::assertExists("slider-banners/$finalName");
        Storage::assertMissing("slider-banners/$existingImageName");
    }
}
