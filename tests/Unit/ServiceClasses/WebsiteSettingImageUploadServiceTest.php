<?php

namespace Tests\Unit\ServiceClasses;

use App\Services\UploadFiles\WebsiteSettingImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebsiteSettingImageUploadServiceTest extends TestCase
{
    public function test_uploadLogo_replaces_logo_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-logo-image.jpg';
        Storage::put("website-settings/$existingImageName", "dummy");
        $newImage = UploadedFile::fake()->image('new-logo-image.jpg');

        // Act
        $service = new WebsiteSettingImageUploadService();
        $finalName = $service->uploadLogo($newImage, $existingImageName);
        Storage::delete("website-settings/$existingImageName");

        // Assert
        Storage::assertExists("website-settings/$finalName");
        Storage::assertMissing("website-settings/$existingImageName");
    }

    public function test_uploadFavicon_replaces_favicon_image(): void
    {
        // Arrange
        Storage::fake();
        $existingImageName = 'existing-favicon-image.jpg';
        Storage::put("website-settings/$existingImageName", "dummy");
        $newImage = UploadedFile::fake()->image('new-favicon-image.jpg');

        // Act
        $service = new WebsiteSettingImageUploadService();
        $finalName = $service->uploadFavicon($newImage, $existingImageName);
        Storage::delete("website-settings/$existingImageName");

        // Assert
        Storage::assertExists("website-settings/$finalName");
        Storage::assertMissing("website-settings/$existingImageName");
    }
}
