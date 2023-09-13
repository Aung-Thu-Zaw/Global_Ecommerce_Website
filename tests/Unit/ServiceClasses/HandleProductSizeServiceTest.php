<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use App\Services\Products\HandleProductSizeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleProductSizeServiceTest extends TestCase
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

    public function test_it_can_handle_sizes(): void
    {
        $sizes = ['sm','md','lg','xl','2xl'];

        (new HandleProductSizeService())->handle($sizes, $this->product);

        $this->assertCount(count($sizes), $this->product->sizes);
        foreach ($sizes as $size) {
            $this->assertContains($size, $this->product->sizes->pluck('name')->all());
        }
    }

    public function test_it_does_not_duplicate_existing_sizes(): void
    {
        $sizes = ['sm','SM','sM','Sm'];

        (new HandleProductSizeService())->handle($sizes, $this->product);

        $this->assertCount(1, $this->product->sizes);
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
