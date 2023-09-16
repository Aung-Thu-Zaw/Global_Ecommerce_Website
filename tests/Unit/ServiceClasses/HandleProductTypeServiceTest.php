<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use App\Services\Products\HandleProductTypeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleProductTypeServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $seller;
    private Category $category;
    private Brand $brand;
    private Collection $collection;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create(["status" => "active", "role" => "seller"]);
        $this->category = Category::factory()->create();
        $this->brand = Brand::factory()->create();
        $this->collection = Collection::factory()->create();
        $this->product = $this->createProduct();
    }

    public function test_it_can_handle_types(): void
    {
        // Arrange
        $types = ['jean','letter','iron','metal','steel'];

        // Act
        $service = new HandleProductTypeService();
        $service->handle($types, $this->product);

        // Assert
        $this->assertCount(count($types), $this->product->types);
        foreach ($types as $type) {
            $this->assertContains($type, $this->product->types->pluck('name')->all());
        }
    }

    public function test_it_does_not_duplicate_existing_types(): void
    {
        // Arrange
        $types = ['jean','JEan','letter','Letter','iron','metal','METAL','steel'];

        // Act
        $service = new HandleProductTypeService();
        $service->handle($types, $this->product);

        // Assert
        $this->assertCount(5, $this->product->types);
    }

    private function createProduct(): Product
    {
        return Product::factory()->create([
            "seller_id" => $this->seller->id,
            "brand_id" => $this->brand->id,
            "collection_id" => $this->collection->id,
            "category_id" => $this->category->id
        ]);
    }
}
