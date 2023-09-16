<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Collection;
use App\Models\DeliveryInformation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Products\HandleProductQuantityService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleProductQuantityServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $seller;
    private User $user;
    private Category $category;
    private Brand $brand;
    private Collection $collection;
    private DeliveryInformation $deliveryInformation;
    private Order $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createUser(role: "user");
        $this->seller = $this->createUser(role: "seller");
        $this->category = Category::factory()->create();
        $this->brand = Brand::factory()->create();
        $this->collection = Collection::factory()->create();
        $this->deliveryInformation = DeliveryInformation::factory()->create(["user_id" => $this->user->id]);
        $this->order = $this->createOrder();
    }

    public function test_update_quantity_subtracts_correctly(): void
    {
        // Arrange
        $product = $this->createProduct(productQty:20);
        $this->createOrderItem(productId: $product->id, qty: 3);

        // Act
        $service = new HandleProductQuantityService();
        $service->updateQuantity($this->order);

        // Assert
        $updatedProduct = Product::find($product->id);
        $this->assertEquals(17, $updatedProduct->qty);
    }

    public function test_update_quantity_handles_multiple_order_items(): void
    {
        // Arrange
        $product1 = $this->createProduct(productQty:20);
        $product2 = $this->createProduct(productQty:10);
        $this->createOrderItem(productId: $product1->id, qty: 2);
        $this->createOrderItem(productId: $product2->id, qty: 5);

        // Act
        $service = new HandleProductQuantityService();
        $service->updateQuantity($this->order);

        // Assert
        $updatedProduct1 = Product::find($product1->id);
        $updatedProduct2 = Product::find($product2->id);
        $this->assertEquals(18, $updatedProduct1->qty);
        $this->assertEquals(5, $updatedProduct2->qty);
    }

    private function createUser(string $role = "user"): User
    {
        return User::factory()->create(["role" => $role,"status" => "active"]);
    }

    private function createProduct(int $productQty = 1): Product
    {
        return Product::factory()->create([
            "seller_id" => $this->seller->id,
            "brand_id" => $this->brand->id,
            "collection_id" => $this->collection->id,
            "category_id" => $this->category->id,
            "qty" => $productQty,
        ]);
    }

    private function createOrder(): Order
    {
        return Order::factory()->create([
            "user_id" => $this->user->id,
            "delivery_information_id" => $this->deliveryInformation->id,
            "order_status" => "pending",
        ]);
    }

    private function createOrderItem(int $productId, int $qty = 1): OrderItem
    {
        return OrderItem::factory()->create([
            "order_id" => $this->order->id,
            "product_id" => $productId,
            "shop_id" => $this->seller->id,
            "qty" => $qty,
        ]);
    }
}
