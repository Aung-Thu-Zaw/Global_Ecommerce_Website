<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\CampaignBannerImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CampaignBannerImageUploadServiceTest extends TestCase
{
    public function test_createImage_uploads_image(): void
    {
        // Arrange
        Storage::fake();
        $image = UploadedFile::fake()->image('campaign-banner-image.jpg');

        // Act
        $service = new CampaignBannerImageUploadService();
        $finalName = $service->createImage($image);

        // Assert
        Storage::assertExists("campaign-banners/$finalName");
    }

    public function test_updateImage_replaces_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-campaign-banner-image.jpg';
        Storage::put("campaign-banners/$existingImageName", 'dummy');
        $newImage = UploadedFile::fake()->image('new-campaign-banner-image.jpg');

        // Act
        $service = new CampaignBannerImageUploadService();
        $finalName = $service->updateImage($newImage, $existingImageName);
        Storage::delete("campaign-banners/$existingImageName");

        // Assert
        Storage::assertExists("campaign-banners/$finalName");
        Storage::assertMissing("campaign-banners/$existingImageName");
    }
}
