<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\User;
use App\Services\Products\HandleProductColorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleProductColorServiceTest extends TestCase
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

    public function test_it_can_handle_colors(): void
    {
        $colors = ['red', 'green', 'blue', 'yellow'];

        (new HandleProductColorService())->handle($colors, $this->product);

        $this->assertCount(count($colors), $this->product->colors);
        foreach ($colors as $color) {
            $this->assertContains($color, $this->product->colors->pluck('name')->all());
        }
    }

    public function test_it_does_not_duplicate_existing_colors(): void
    {
        $colors = ['red','Red','green','gREEn','blue','blue'];

        (new HandleProductColorService())->handle($colors, $this->product);

        $this->assertCount(3, $this->product->colors);
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
