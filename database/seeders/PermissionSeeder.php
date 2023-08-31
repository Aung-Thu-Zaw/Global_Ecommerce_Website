<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        Permission::create(["name" => "brand.menu","group" => "brand"]);
        Permission::create(["name" => "brand.add","group" => "brand"]);
        Permission::create(["name" => "brand.edit","group" => "brand"]);
        Permission::create(["name" => "brand.delete","group" => "brand"]);
        Permission::create(["name" => "brand.trash.list","group" => "brand"]);
        Permission::create(["name" => "brand.trash.restore","group" => "brand"]);
        Permission::create(["name" => "brand.trash.delete","group" => "brand"]);

        Permission::create(["name" => "collection.menu","group" => "collection"]);
        Permission::create(["name" => "collection.add","group" => "collection"]);
        Permission::create(["name" => "collection.edit","group" => "collection"]);
        Permission::create(["name" => "collection.delete","group" => "collection"]);
        Permission::create(["name" => "collection.trash.list","group" => "collection"]);
        Permission::create(["name" => "collection.trash.restore","group" => "collection"]);
        Permission::create(["name" => "collection.trash.delete","group" => "collection"]);

        Permission::create(["name" => "category.menu","group" => "category"]);
        Permission::create(["name" => "category.add","group" => "category"]);
        Permission::create(["name" => "category.edit","group" => "category"]);
        Permission::create(["name" => "category.delete","group" => "category"]);
        Permission::create(["name" => "category.trash.list","group" => "category"]);
        Permission::create(["name" => "category.trash.restore","group" => "category"]);
        Permission::create(["name" => "category.trash.delete","group" => "category"]);

        Permission::create(["name" => "product.menu","group" => "product"]);
        Permission::create(["name" => "product.add","group" => "product"]);
        Permission::create(["name" => "product.control","group" => "product"]);
        Permission::create(["name" => "product.edit","group" => "product"]);
        Permission::create(["name" => "product.delete","group" => "product"]);
        Permission::create(["name" => "product.detail","group" => "product"]);
        Permission::create(["name" => "product.trash.list","group" => "product"]);
        Permission::create(["name" => "product.trash.restore","group" => "product"]);
        Permission::create(["name" => "product.trash.delete","group" => "product"]);

        Permission::create(["name" => "coupon.menu","group" => "coupon"]);
        Permission::create(["name" => "coupon.add","group" => "coupon"]);
        Permission::create(["name" => "coupon.edit","group" => "coupon"]);
        Permission::create(["name" => "coupon.delete","group" => "coupon"]);
        Permission::create(["name" => "coupon.trash.list","group" => "coupon"]);
        Permission::create(["name" => "coupon.trash.restore","group" => "coupon"]);
        Permission::create(["name" => "coupon.trash.delete","group" => "coupon"]);

        Permission::create(["name" => "flash-sale.menu","group" => "flash-sale"]);
        Permission::create(["name" => "flash-sale.edit","group" => "flash-sale"]);

        Permission::create(["name" => "banner.menu","group" => "banner"]);
        Permission::create(["name" => "banner.add","group" => "banner"]);
        Permission::create(["name" => "banner.edit","group" => "banner"]);
        Permission::create(["name" => "banner.delete","group" => "banner"]);
        Permission::create(["name" => "banner.trash.list","group" => "banner"]);
        Permission::create(["name" => "banner.trash.restore","group" => "banner"]);
        Permission::create(["name" => "banner.trash.delete","group" => "banner"]);
        Permission::create(["name" => "banner.control","group" => "banner"]);

        Permission::create(["name" => "shipping-area.menu","group" => "shipping-area"]);
        Permission::create(["name" => "shipping-area.add","group" => "shipping-area"]);
        Permission::create(["name" => "shipping-area.edit","group" => "shipping-area"]);
        Permission::create(["name" => "shipping-area.delete","group" => "shipping-area"]);
        Permission::create(["name" => "shipping-area.trash.list","group" => "shipping-area"]);
        Permission::create(["name" => "shipping-area.trash.restore","group" => "shipping-area"]);
        Permission::create(["name" => "shipping-area.trash.delete","group" => "shipping-area"]);

        Permission::create(["name" => "order-manage.menu","group" => "order-manage"]);
        Permission::create(["name" => "order-manage.detail","group" => "order-manage"]);
        Permission::create(["name" => "order-manage.control","group" => "order-manage"]);

        Permission::create(["name" => "return-order-manage.menu","group" => "return-order-manage"]);
        Permission::create(["name" => "return-order-manage.detail","group" => "return-order-manage"]);
        Permission::create(["name" => "return-order-manage.control","group" => "return-order-manage"]);

        Permission::create(["name" => "cancel-order-manage.menu","group" => "cancel-order-manage"]);
        Permission::create(["name" => "cancel-order-manage.detail","group" => "cancel-order-manage"]);
        Permission::create(["name" => "cancel-order-manage.control","group" => "cancel-order-manage"]);

        Permission::create(["name" => "shop-review.menu","group" => "shop-review"]);
        Permission::create(["name" => "shop-review.detail","group" => "shop-review"]);
        Permission::create(["name" => "shop-review.control","group" => "shop-review"]);
        Permission::create(["name" => "shop-review.delete","group" => "shop-review"]);
        Permission::create(["name" => "shop-review.trash.list","group" => "shop-review"]);
        Permission::create(["name" => "shop-review.trash.restore","group" => "shop-review"]);
        Permission::create(["name" => "shop-review.trash.delete","group" => "shop-review"]);

        Permission::create(["name" => "product-review.menu","group" => "product-review"]);
        Permission::create(["name" => "product-review.detail","group" => "product-review"]);
        Permission::create(["name" => "product-review.control","group" => "product-review"]);
        Permission::create(["name" => "product-review.delete","group" => "product-review"]);
        Permission::create(["name" => "product-review.trash.list","group" => "product-review"]);
        Permission::create(["name" => "product-review.trash.restore","group" => "product-review"]);
        Permission::create(["name" => "product-review.trash.delete","group" => "product-review"]);

        Permission::create(["name" => "seller-manage.menu","group" => "seller-manage"]);
        Permission::create(["name" => "seller-manage.detail","group" => "seller-manage"]);
        Permission::create(["name" => "seller-manage.control","group" => "seller-manage"]);
        Permission::create(["name" => "seller-manage.delete","group" => "seller-manage"]);
        Permission::create(["name" => "seller-manage.trash.list","group" => "seller-manage"]);
        Permission::create(["name" => "seller-manage.trash.restore","group" => "seller-manage"]);
        Permission::create(["name" => "seller-manage.trash.delete","group" => "seller-manage"]);

        Permission::create(["name" => "registered-account.menu","group" => "registered-account"]);
        Permission::create(["name" => "registered-account.detail","group" => "registered-account"]);
        Permission::create(["name" => "registered-account.delete","group" => "registered-account"]);
        Permission::create(["name" => "registered-account.trash.list","group" => "registered-account"]);
        Permission::create(["name" => "registered-account.trash.restore","group" => "registered-account"]);
        Permission::create(["name" => "registered-account.trash.delete","group" => "registered-account"]);

        Permission::create(["name" => "admin-manage.menu","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.detail","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.add","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.edit","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.delete","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.trash.list","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.trash.restore","group" => "admin-manage"]);
        Permission::create(["name" => "admin-manage.trash.delete","group" => "admin-manage"]);

        Permission::create(["name" => "role-and-permission.menu","group" => "role-and-permission"]);
        Permission::create(["name" => "role-and-permission.add","group" => "role-and-permission"]);
        Permission::create(["name" => "role-and-permission.edit","group" => "role-and-permission"]);
        Permission::create(["name" => "role-and-permission.delete","group" => "role-and-permission"]);
        Permission::create(["name" => "role-and-permission.trash.list","group" => "role-and-permission"]);
        Permission::create(["name" => "role-and-permission.trash.restore","group" => "role-and-permission"]);
        Permission::create(["name" => "role-and-permission.trash.delete","group" => "role-and-permission"]);

        Permission::create(["name" => "role-in-permissions.menu","group" => "role-in-permissions"]);
        Permission::create(["name" => "role-in-permissions.add","group" => "role-in-permissions"]);
        Permission::create(["name" => "role-in-permissions.edit","group" => "role-in-permissions"]);
        Permission::create(["name" => "role-in-permissions.delete","group" => "role-in-permissions"]);

        Permission::create(["name" => "blog-category.menu","group" => "blog-category"]);
        Permission::create(["name" => "blog-category.add","group" => "blog-category"]);
        Permission::create(["name" => "blog-category.edit","group" => "blog-category"]);
        Permission::create(["name" => "blog-category.delete","group" => "blog-category"]);
        Permission::create(["name" => "blog-category.trash.list","group" => "blog-category"]);
        Permission::create(["name" => "blog-category.trash.restore","group" => "blog-category"]);
        Permission::create(["name" => "blog-category.trash.delete","group" => "blog-category"]);

        Permission::create(["name" => "blog-post.menu","group" => "blog-post"]);
        Permission::create(["name" => "blog-post.add","group" => "blog-post"]);
        Permission::create(["name" => "blog-post.edit","group" => "blog-post"]);
        Permission::create(["name" => "blog-post.delete","group" => "blog-post"]);
        Permission::create(["name" => "blog-post.trash.list","group" => "blog-post"]);
        Permission::create(["name" => "blog-post.trash.restore","group" => "blog-post"]);
        Permission::create(["name" => "blog-post.trash.delete","group" => "blog-post"]);

        Permission::create(["name" => "blog-comment.menu","group" => "blog-comment"]);
        Permission::create(["name" => "blog-comment.delete","group" => "blog-comment"]);
        Permission::create(["name" => "blog-comment.trash.list","group" => "blog-comment"]);
        Permission::create(["name" => "blog-comment.trash.restore","group" => "blog-comment"]);
        Permission::create(["name" => "blog-comment.trash.delete","group" => "blog-comment"]);

        Permission::create(["name" => "setting.menu","group" => "setting"]);
        Permission::create(["name" => "setting.edit","group" => "setting"]);

        Permission::create(["name" => "page.menu","group" => "page"]);
        Permission::create(["name" => "page.edit","group" => "page"]);

        Permission::create(["name" => "faq-category.menu","group" => "faq-category"]);
        Permission::create(["name" => "faq-category.add","group" => "faq-category"]);
        Permission::create(["name" => "faq-category.edit","group" => "faq-category"]);
        Permission::create(["name" => "faq-category.delete","group" => "faq-category"]);
        Permission::create(["name" => "faq-category.trash.list","group" => "faq-category"]);
        Permission::create(["name" => "faq-category.trash.restore","group" => "faq-category"]);
        Permission::create(["name" => "faq-category.trash.delete","group" => "faq-category"]);

        Permission::create(["name" => "faq.menu","group" => "faq"]);
        Permission::create(["name" => "faq.add","group" => "faq"]);
        Permission::create(["name" => "faq.edit","group" => "faq"]);
        Permission::create(["name" => "faq.delete","group" => "faq"]);
        Permission::create(["name" => "faq.trash.list","group" => "faq"]);
        Permission::create(["name" => "faq.trash.restore","group" => "faq"]);
        Permission::create(["name" => "faq.trash.delete","group" => "faq"]);

        Permission::create(["name" => "chat.menu","group" => "chat"]);

        Permission::create(["name" => "suggestion.menu","group" => "suggestion"]);
        Permission::create(["name" => "suggestion.detail","group" => "suggestion"]);
        Permission::create(["name" => "suggestion.delete","group" => "suggestion"]);
        Permission::create(["name" => "suggestion.trash.list","group" => "suggestion"]);
        Permission::create(["name" => "suggestion.trash.restore","group" => "suggestion"]);
        Permission::create(["name" => "suggestion.trash.delete","group" => "suggestion"]);

        Permission::create(["name" => "website-feedback.menu","group" => "website-feedback"]);
        Permission::create(["name" => "website-feedback.detail","group" => "website-feedback"]);
        Permission::create(["name" => "website-feedback.delete","group" => "website-feedback"]);
        Permission::create(["name" => "website-feedback.trash.list","group" => "website-feedback"]);
        Permission::create(["name" => "website-feedback.trash.restore","group" => "website-feedback"]);
        Permission::create(["name" => "website-feedback.trash.delete","group" => "website-feedback"]);

        Permission::create(["name" => "subscriber.menu","group" => "subscriber"]);
        Permission::create(["name" => "subscriber.delete","group" => "subscriber"]);
        Permission::create(["name" => "subscriber.trash.list","group" => "subscriber"]);
        Permission::create(["name" => "subscriber.trash.restore","group" => "subscriber"]);
        Permission::create(["name" => "subscriber.trash.delete","group" => "subscriber"]);
    }
}
