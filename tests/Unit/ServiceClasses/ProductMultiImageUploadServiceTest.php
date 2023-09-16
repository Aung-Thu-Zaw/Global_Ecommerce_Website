<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use App\Services\UploadFiles\ProductMultiImageUploadService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductMultiImageUploadServiceTest extends TestCase
{
    public function test_createMultiImage_uploads_multiple_images(): void
    {
        // Arrange
        Storage::fake();

        $seller = User::factory()->create(["status" => "active", "role" => "seller"]);
        $category = Category::factory()->create();
        $brand = Brand::factory()->create();
        $collection = Collection::factory()->create();
        $product =  Product::factory()->create(["seller_id" => $seller->id,"brand_id" => $brand->id,"collection_id" => $collection->id,"category_id" => $category->id]);
        $images = [
            UploadedFile::fake()->image('test-product-image1.jpg'),
            UploadedFile::fake()->image('test-product-image2.jpg'),
            UploadedFile::fake()->image('test-product-image3.jpg'),
        ];

        // Act
        $service = new ProductMultiImageUploadService();
        $service->createMultiImage($images, $product);

        // Assert
        Storage::assertExists('products/');
        $this->assertCount(count($images), $product->images);
    }
}
