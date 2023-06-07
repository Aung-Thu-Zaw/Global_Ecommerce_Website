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
        Permission::create(["name"=>"brand.list","group"=>"brand"]);
        Permission::create(["name"=>"brand.add","group"=>"brand"]);
        Permission::create(["name"=>"brand.edti","group"=>"brand"]);
        Permission::create(["name"=>"brand.delete","group"=>"brand"]);
        Permission::create(["name"=>"brand.trash.list","group"=>"brand"]);
        Permission::create(["name"=>"brand.trash.restore","group"=>"brand"]);
        Permission::create(["name"=>"brand.delete.trash","group"=>"brand"]);

        Permission::create(["name"=>"collection.menu","group"=>"collection"]);
        Permission::create(["name"=>"collection.list","group"=>"collection"]);
        Permission::create(["name"=>"collection.add","group"=>"collection"]);
        Permission::create(["name"=>"collection.edti","group"=>"collection"]);
        Permission::create(["name"=>"collection.delete","group"=>"collection"]);
        Permission::create(["name"=>"collection.trash.list","group"=>"collection"]);
        Permission::create(["name"=>"collection.trash.restore","group"=>"collection"]);
        Permission::create(["name"=>"collection.delete.trash","group"=>"collection"]);

        Permission::create(["name"=>"category.menu","group"=>"category"]);
        Permission::create(["name"=>"category.list","group"=>"category"]);
        Permission::create(["name"=>"category.add","group"=>"category"]);
        Permission::create(["name"=>"category.edti","group"=>"category"]);
        Permission::create(["name"=>"category.delete","group"=>"category"]);
        Permission::create(["name"=>"category.trash.list","group"=>"category"]);
        Permission::create(["name"=>"category.trash.restore","group"=>"category"]);
        Permission::create(["name"=>"category.delete.trash","group"=>"category"]);

        Permission::create(["name"=>"product.menu","group"=>"product"]);
        Permission::create(["name"=>"product.list","group"=>"product"]);
        Permission::create(["name"=>"product.add","group"=>"product"]);
        Permission::create(["name"=>"product.edti","group"=>"product"]);
        Permission::create(["name"=>"product.delete","group"=>"product"]);
        Permission::create(["name"=>"product.trash.list","group"=>"product"]);
        Permission::create(["name"=>"product.trash.restore","group"=>"product"]);
        Permission::create(["name"=>"product.delete.trash","group"=>"product"]);

        Permission::create(["name"=>"coupon.menu","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.list","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.add","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.edti","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.delete","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.trash.list","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.trash.restore","group"=>"coupon"]);
        Permission::create(["name"=>"coupon.delete.trash","group"=>"coupon"]);

        Permission::create(["name"=>"banner.menu","group"=>"banner"]);
        Permission::create(["name"=>"banner.list","group"=>"banner"]);
        Permission::create(["name"=>"banner.add","group"=>"banner"]);
        Permission::create(["name"=>"banner.edti","group"=>"banner"]);
        Permission::create(["name"=>"banner.delete","group"=>"banner"]);
        Permission::create(["name"=>"banner.trash.list","group"=>"banner"]);
        Permission::create(["name"=>"banner.trash.restore","group"=>"banner"]);
        Permission::create(["name"=>"banner.delete.trash","group"=>"banner"]);

        Permission::create(["name"=>"shipping-area.menu","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.list","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.add","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.edti","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.delete","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.trash.list","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.trash.restore","group"=>"shipping-area"]);
        Permission::create(["name"=>"shipping-area.delete.trash","group"=>"shipping-area"]);

        Permission::create(["name"=>"order-manage.menu","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.list","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.add","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.edti","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.delete","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.trash.list","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.trash.restore","group"=>"order-manage"]);
        Permission::create(["name"=>"order-manage.delete.trash","group"=>"order-manage"]);

        Permission::create(["name"=>"return-order-manage.menu","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.list","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.add","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.edti","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.delete","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.trash.list","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.trash.restore","group"=>"return-order-manage"]);
        Permission::create(["name"=>"return-order-manage.delete.trash","group"=>"return-order-manage"]);

        Permission::create(["name"=>"cancel-order-manage.menu","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.list","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.add","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.edti","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.delete","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.trash.list","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.trash.restore","group"=>"cancel-order-manage"]);
        Permission::create(["name"=>"cancel-order-manage.delete.trash","group"=>"cancel-order-manage"]);

        Permission::create(["name"=>"vendor-manage.menu","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.list","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.add","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.edti","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.delete","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.trash.list","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.trash.restore","group"=>"vendor-manage"]);
        Permission::create(["name"=>"vendor-manage.delete.trash","group"=>"vendor-manage"]);

        Permission::create(["name"=>"user-manage.menu","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.list","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.add","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.edti","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.delete","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.trash.list","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.trash.restore","group"=>"user-manage"]);
        Permission::create(["name"=>"user-manage.delete.trash","group"=>"user-manage"]);

        Permission::create(["name"=>"role-and-permission.menu","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.list","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.add","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.edti","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.delete","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.trash.list","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.trash.restore","group"=>"role-and-permission"]);
        Permission::create(["name"=>"role-and-permission.delete.trash","group"=>"role-and-permission"]);

        Permission::create(["name"=>"blog-category.menu","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.list","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.add","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.edti","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.delete","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.trash.list","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.trash.restore","group"=>"blog-category"]);
        Permission::create(["name"=>"blog-category.delete.trash","group"=>"blog-category"]);

        Permission::create(["name"=>"blog-post.menu","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.list","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.add","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.edti","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.delete","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.trash.list","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.trash.restore","group"=>"blog-post"]);
        Permission::create(["name"=>"blog-post.delete.trash","group"=>"blog-post"]);

        Permission::create(["name"=>"website-setting.menu","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.list","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.add","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.edti","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.delete","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.trash.list","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.trash.restore","group"=>"website-setting"]);
        Permission::create(["name"=>"website-setting.delete.trash","group"=>"website-setting"]);

        Permission::create(["name"=>"seo-setting.menu","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.list","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.add","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.edti","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.delete","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.trash.list","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.trash.restore","group"=>"seo-setting"]);
        Permission::create(["name"=>"seo-setting.delete.trash","group"=>"seo-setting"]);
    }
}
