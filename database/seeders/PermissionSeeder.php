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
        Permission::create(["name"=>"brand.menu","group"=>"brand"]);
        Permission::create(["name"=>"brand.add","group"=>"brand"]);
        Permission::create(["name"=>"brand.edit","group"=>"brand"]);
        Permission::create(["name"=>"brand.delete","group"=>"brand"]);
        Permission::create(["name"=>"brand.trash.list","group"=>"brand"]);
        Permission::create(["name"=>"brand.trash.restore","group"=>"brand"]);
        Permission::create(["name"=>"brand.delete.trash","group"=>"brand"]);

        Permission::create(["name"=>"collection.menu","group"=>"collection"]);
        Permission::create(["name"=>"collection.add","group"=>"collection"]);
        Permission::create(["name"=>"collection.edit","group"=>"collection"]);
        Permission::create(["name"=>"collection.delete","group"=>"collection"]);
        Permission::create(["name"=>"collection.trash.list","group"=>"collection"]);
        Permission::create(["name"=>"collection.trash.restore","group"=>"collection"]);
        Permission::create(["name"=>"collection.delete.trash","group"=>"collection"]);

        Permission::create(["name"=>"category.menu","group"=>"category"]);
        Permission::create(["name"=>"category.add","group"=>"category"]);
        Permission::create(["name"=>"category.edit","group"=>"category"]);
        Permission::create(["name"=>"category.delete","group"=>"category"]);
        Permission::create(["name"=>"category.trash.list","group"=>"category"]);
        Permission::create(["name"=>"category.trash.restore","group"=>"category"]);
        Permission::create(["name"=>"category.delete.trash","group"=>"category"]);

        Permission::create(["name"=>"product.menu","group"=>"product"]);
        Permission::create(["name"=>"product.add","group"=>"product"]);
        Permission::create(["name"=>"product.edit","group"=>"product"]);
        Permission::create(["name"=>"product.delete","group"=>"product"]);
        Permission::create(["name"=>"product.detail","group"=>"product"]);
        Permission::create(["name"=>"product.trash.list","group"=>"product"]);
        Permission::create(["name"=>"product.trash.restore","group"=>"product"]);
        Permission::create(["name"=>"product.delete.trash","group"=>"product"]);

        Permission::create(["name"=>"coupon.menu","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.add","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.edit","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.delete","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.trash.list","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.trash.restore","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.delete.trash","group"=>"coupon"]);

        Permission::create(["name"=>"banner.menu","group"=>"banner"]);
        Permission::create(["name"=>"banner.add","group"=>"banner"]);
        Permission::create(["name"=>"banner.edit","group"=>"banner"]);
        Permission::create(["name"=>"banner.delete","group"=>"banner"]);
        Permission::create(["name"=>"banner.trash.list","group"=>"banner"]);
        Permission::create(["name"=>"banner.trash.restore","group"=>"banner"]);
        Permission::create(["name"=>"banner.delete.trash","group"=>"banner"]);
        Permission::create(["name"=>"banner.show","group"=>"banner"]);
        Permission::create(["name"=>"banner.hide","group"=>"banner"]);

        Permission::create(["name"=>"shipping-area.menu","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.add","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.edit","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.delete","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.trash.list","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.trash.restore","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.delete.trash","group"=>"shipping-area"]);

        Permission::create(["name"=>"order-manage.menu","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.detail","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.edit","group"=>"order-manage"]);

        Permission::create(["name"=>"return-order-manage.menu","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.detail","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.edit","group"=>"return-order-manage"]);

        Permission::create(["name"=>"cancel-order-manage.menu","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.detail","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.edit","group"=>"cancel-order-manage"]);

        Permission::create(["name"=>"vendor-manage.menu","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.detail","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.add","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.edit","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.delete","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.trash.list","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.trash.restore","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.delete.trash","group"=>"vendor-manage"]);

        Permission::create(["name"=>"user-manage.menu","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.detail","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.add","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.edit","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.delete","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.trash.list","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.trash.restore","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.delete.trash","group"=>"user-manage"]);

        Permission::create(["name"=>"admin-manage.menu","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.detail","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.add","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.edit","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.delete","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.trash.list","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.trash.restore","group"=>"admin-manage"]);
        Permission::create(["name"=>"admin-manage.delete.trash","group"=>"admin-manage"]);

        Permission::create(["name"=>"role-and-permission.menu","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.add","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.edit","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.delete","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.trash.list","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.trash.restore","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.delete.trash","group"=>"role-and-permission"]);

        Permission::create(["name"=>"role-in-permissions.menu","group"=>"role-in-permissions"]);
        Permission::create(["name"=>"role-in-permissions.add","group"=>"role-in-permissions"]);
        Permission::create(["name"=>"role-in-permissions.edit","group"=>"role-in-permissions"]);
        Permission::create(["name"=>"role-in-permissions.delete","group"=>"role-in-permissions"]);

        Permission::create(["name"=>"blog-category.menu","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.add","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.edit","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.delete","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.trash.list","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.trash.restore","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.delete.trash","group"=>"blog-category"]);

        Permission::create(["name"=>"blog-post.menu","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.add","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.edit","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.delete","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.trash.list","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.trash.restore","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.delete.trash","group"=>"blog-post"]);

        Permission::create(["name"=>"website-setting.menu","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.edit","group"=>"website-setting"]);

        Permission::create(["name"=>"seo-setting.menu","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.edit","group"=>"seo-setting"]);
    }
}
