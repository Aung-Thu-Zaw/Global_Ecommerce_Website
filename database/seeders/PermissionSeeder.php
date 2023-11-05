<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Brand
        Permission::create(['name' => 'brands.view', 'group' => 'Brand']);
        Permission::create(['name' => 'brands.create', 'group' => 'Brand']);
        Permission::create(['name' => 'brands.edit', 'group' => 'Brand']);
        Permission::create(['name' => 'brands.delete', 'group' => 'Brand']);
        Permission::create(['name' => 'brands.view.trash', 'group' => 'Brand']);
        Permission::create(['name' => 'brands.restore', 'group' => 'Brand']);
        Permission::create(['name' => 'brands.force.delete', 'group' => 'Brand']);

        // Collection
        Permission::create(['name' => 'collections.view', 'group' => 'Collection']);
        Permission::create(['name' => 'collections.create', 'group' => 'Collection']);
        Permission::create(['name' => 'collections.edit', 'group' => 'Collection']);
        Permission::create(['name' => 'collections.delete', 'group' => 'Collection']);
        Permission::create(['name' => 'collections.view.trash', 'group' => 'Collection']);
        Permission::create(['name' => 'collections.restore', 'group' => 'Collection']);
        Permission::create(['name' => 'collections.force.delete', 'group' => 'Collection']);

        // Category
        Permission::create(['name' => 'categories.view', 'group' => 'Category']);
        Permission::create(['name' => 'categories.create', 'group' => 'Category']);
        Permission::create(['name' => 'categories.edit', 'group' => 'Category']);
        Permission::create(['name' => 'categories.delete', 'group' => 'Category']);
        Permission::create(['name' => 'categories.view.trash', 'group' => 'Category']);
        Permission::create(['name' => 'categories.restore', 'group' => 'Category']);
        Permission::create(['name' => 'categories.force.delete', 'group' => 'Category']);

        // Product
        Permission::create(['name' => 'products.view', 'group' => 'Product']);
        Permission::create(['name' => 'products.create', 'group' => 'Product']);
        Permission::create(['name' => 'products.edit', 'group' => 'Product']);
        Permission::create(['name' => 'products.delete', 'group' => 'Product']);
        Permission::create(['name' => 'products.view.trash', 'group' => 'Product']);
        Permission::create(['name' => 'products.restore', 'group' => 'Product']);
        Permission::create(['name' => 'products.force.delete', 'group' => 'Product']);

        // Coupon
        Permission::create(['name' => 'coupons.view', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.create', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.edit', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.delete', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.view.trash', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.restore', 'group' => 'Coupon']);
        Permission::create(['name' => 'coupons.force.delete', 'group' => 'Coupon']);

        // Flash Sale
        Permission::create(['name' => 'flash-sale.view', 'group' => 'Flash Sale']);
        Permission::create(['name' => 'flash-sale.create', 'group' => 'Flash Sale']);

        Permission::create(['name' => 'banners.view', 'group' => 'Banner']);
        Permission::create(['name' => 'banners.create', 'group' => 'Banner']);
        Permission::create(['name' => 'banners.edit', 'group' => 'Banner']);
        Permission::create(['name' => 'banners.delete', 'group' => 'Banner']);
        Permission::create(['name' => 'banners.view.trash', 'group' => 'Banner']);
        Permission::create(['name' => 'banners.restore', 'group' => 'Banner']);
        Permission::create(['name' => 'banners.force.delete', 'group' => 'Banner']);

        Permission::create(['name' => 'shipping-areas.view', 'group' => 'Shipping Area']);
        Permission::create(['name' => 'shipping-areas.create', 'group' => 'Shipping Area']);
        Permission::create(['name' => 'shipping-areas.edit', 'group' => 'Shipping Area']);
        Permission::create(['name' => 'shipping-areas.delete', 'group' => 'Shipping Area']);
        Permission::create(['name' => 'shipping-areas.view.trash', 'group' => 'Shipping Area']);
        Permission::create(['name' => 'shipping-areas.restore', 'group' => 'Shipping Area']);
        Permission::create(['name' => 'shipping-areas.force.delete', 'group' => 'Shipping Area']);

        // Permission::create(["name" => "order-manage","group" => "order-manage"]);
        // Permission::create(["name" => "order-manage.detail","group" => "order-manage"]);
        // Permission::create(["name" => "order-manage.control","group" => "order-manage"]);

        // Permission::create(["name" => "return-order-manage","group" => "return-order-manage"]);
        // Permission::create(["name" => "return-order-manage.detail","group" => "return-order-manage"]);
        // Permission::create(["name" => "return-order-manage.control","group" => "return-order-manage"]);

        // Permission::create(["name" => "cancel-order-manage","group" => "cancel-order-manage"]);
        // Permission::create(["name" => "cancel-order-manage.detail","group" => "cancel-order-manage"]);
        // Permission::create(["name" => "cancel-order-manage.control","group" => "cancel-order-manage"]);

        // Permission::create(["name" => "shop-review","group" => "shop-review"]);
        // Permission::create(["name" => "shop-review.detail","group" => "shop-review"]);
        // Permission::create(["name" => "shop-review.control","group" => "shop-review"]);
        // Permission::create(["name" => "shop-review","group" => "shop-review"]);
        // Permission::create(["name" => "shop-review","group" => "shop-review"]);
        // Permission::create(["name" => "shop-review","group" => "shop-review"]);
        // Permission::create(["name" => "shop-review","group" => "shop-review"]);

        // Permission::create(["name" => "product-review","group" => "product-review"]);
        // Permission::create(["name" => "product-review.detail","group" => "product-review"]);
        // Permission::create(["name" => "product-review.control","group" => "product-review"]);
        // Permission::create(["name" => "product-review","group" => "product-review"]);
        // Permission::create(["name" => "product-review","group" => "product-review"]);
        // Permission::create(["name" => "product-review","group" => "product-review"]);
        // Permission::create(["name" => "product-review","group" => "product-review"]);

        // Permission::create(["name" => "seller-manage","group" => "seller-manage"]);
        // Permission::create(["name" => "seller-manage.detail","group" => "seller-manage"]);
        // Permission::create(["name" => "seller-manage.control","group" => "seller-manage"]);
        // Permission::create(["name" => "seller-manage","group" => "seller-manage"]);
        // Permission::create(["name" => "seller-manage","group" => "seller-manage"]);
        // Permission::create(["name" => "seller-manage","group" => "seller-manage"]);
        // Permission::create(["name" => "seller-manage","group" => "seller-manage"]);

        // Permission::create(["name" => "registered-account","group" => "registered-account"]);
        // Permission::create(["name" => "registered-account.detail","group" => "registered-account"]);
        // Permission::create(["name" => "registered-account","group" => "registered-account"]);
        // Permission::create(["name" => "registered-account","group" => "registered-account"]);
        // Permission::create(["name" => "registered-account","group" => "registered-account"]);
        // Permission::create(["name" => "registered-account","group" => "registered-account"]);

        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage.detail","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);
        // Permission::create(["name" => "admin-manage","group" => "admin-manage"]);

        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);
        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);
        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);
        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);
        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);
        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);
        // Permission::create(["name" => "role-and-permission","group" => "role-and-permission"]);

        // Permission::create(["name" => "role-in-permissions","group" => "role-in-permissions"]);
        // Permission::create(["name" => "role-in-permissions","group" => "role-in-permissions"]);
        // Permission::create(["name" => "role-in-permissions","group" => "role-in-permissions"]);
        // Permission::create(["name" => "role-in-permissions","group" => "role-in-permissions"]);

        // Permission::create(["name" => "blog-category","group" => "blog-category"]);
        // Permission::create(["name" => "blog-category","group" => "blog-category"]);
        // Permission::create(["name" => "blog-category","group" => "blog-category"]);
        // Permission::create(["name" => "blog-category","group" => "blog-category"]);
        // Permission::create(["name" => "blog-category","group" => "blog-category"]);
        // Permission::create(["name" => "blog-category","group" => "blog-category"]);
        // Permission::create(["name" => "blog-category","group" => "blog-category"]);

        // Permission::create(["name" => "blog-post","group" => "blog-post"]);
        // Permission::create(["name" => "blog-post","group" => "blog-post"]);
        // Permission::create(["name" => "blog-post","group" => "blog-post"]);
        // Permission::create(["name" => "blog-post","group" => "blog-post"]);
        // Permission::create(["name" => "blog-post","group" => "blog-post"]);
        // Permission::create(["name" => "blog-post","group" => "blog-post"]);
        // Permission::create(["name" => "blog-post","group" => "blog-post"]);

        // Permission::create(["name" => "blog-comment","group" => "blog-comment"]);
        // Permission::create(["name" => "blog-comment","group" => "blog-comment"]);
        // Permission::create(["name" => "blog-comment","group" => "blog-comment"]);
        // Permission::create(["name" => "blog-comment","group" => "blog-comment"]);
        // Permission::create(["name" => "blog-comment","group" => "blog-comment"]);

        // Permission::create(["name" => "setting","group" => "setting"]);
        // Permission::create(["name" => "setting","group" => "setting"]);

        // Permission::create(["name" => "page","group" => "page"]);
        // Permission::create(["name" => "page","group" => "page"]);

        // Permission::create(["name" => "faq-category","group" => "faq-category"]);
        // Permission::create(["name" => "faq-category","group" => "faq-category"]);
        // Permission::create(["name" => "faq-category","group" => "faq-category"]);
        // Permission::create(["name" => "faq-category","group" => "faq-category"]);
        // Permission::create(["name" => "faq-category","group" => "faq-category"]);
        // Permission::create(["name" => "faq-category","group" => "faq-category"]);
        // Permission::create(["name" => "faq-category","group" => "faq-category"]);

        // Permission::create(["name" => "faq","group" => "faq"]);
        // Permission::create(["name" => "faq","group" => "faq"]);
        // Permission::create(["name" => "faq","group" => "faq"]);
        // Permission::create(["name" => "faq","group" => "faq"]);
        // Permission::create(["name" => "faq","group" => "faq"]);
        // Permission::create(["name" => "faq","group" => "faq"]);
        // Permission::create(["name" => "faq","group" => "faq"]);

        // Permission::create(["name" => "chat","group" => "chat"]);

        // Permission::create(["name" => "suggestion","group" => "suggestion"]);
        // Permission::create(["name" => "suggestion.detail","group" => "suggestion"]);
        // Permission::create(["name" => "suggestion","group" => "suggestion"]);
        // Permission::create(["name" => "suggestion","group" => "suggestion"]);
        // Permission::create(["name" => "suggestion","group" => "suggestion"]);
        // Permission::create(["name" => "suggestion","group" => "suggestion"]);

        // Permission::create(["name" => "website-feedback","group" => "website-feedback"]);
        // Permission::create(["name" => "website-feedback.detail","group" => "website-feedback"]);
        // Permission::create(["name" => "website-feedback","group" => "website-feedback"]);
        // Permission::create(["name" => "website-feedback","group" => "website-feedback"]);
        // Permission::create(["name" => "website-feedback","group" => "website-feedback"]);
        // Permission::create(["name" => "website-feedback","group" => "website-feedback"]);

        // Permission::create(["name" => "subscriber","group" => "subscriber"]);
        // Permission::create(["name" => "subscriber","group" => "subscriber"]);
        // Permission::create(["name" => "subscriber","group" => "subscriber"]);
        // Permission::create(["name" => "subscriber","group" => "subscriber"]);
        // Permission::create(["name" => "subscriber","group" => "subscriber"]);
    }
}
