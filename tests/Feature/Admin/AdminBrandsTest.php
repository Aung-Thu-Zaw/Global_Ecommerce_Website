<?php

namespace Tests\Feature\Admin;

use App\Models\Brand;
use App\Models\User;
use Database\Seeders\SeoSettingSeeder;
use Database\Seeders\WebsiteSettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class AdminBrandsTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $seller;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = $this->createUser(role: "admin");
        $this->seller = $this->createUser(role: "seller");
        $this->user = $this->createUser(role: "user");
    }

    public function test_necessary_seeders_executed_successfully()
    {
        $this->seed([
            SeoSettingSeeder::class,
            WebsiteSettingSeeder::class,
        ]);


        $this->assertTrue(true);
    }

    public function test_admin_without_brand_menu_permission_cannot_access_brand_lists_page_with_pagination_and_query_parameters(): void
    {
        $response = $this->actingAs($this->admin)->get("/admin/brands?page=1&per_page=10&sort=id&direction=desc");

        $response->assertForbidden();
        $response->assertDontSee(__("BRANDS"));
    }

    public function test_admin_without_brand_menu_permission_cannot_access_brand_lists_page_without_query_parameters(): void
    {
        $response = $this->actingAs($this->admin)->get("admin/brands");

        $response->assertForbidden();
        $response->assertDontSee(__("BRANDS"));
    }

    public function test_non_admin_cannot_access_brand_lists_page_with_pagination_and_query_parameters(): void
    {
        $responseUser = $this->actingAs($this->user)->get("/admin/brands?page=1&per_page=10&sort=id&direction=desc");
        $responseSeller = $this->actingAs($this->seller)->get("/admin/brands?page=1&per_page=10&sort=id&direction=desc");

        $responseUser->assertForbidden();
        $responseUser->assertDontSee(__("BRANDS"));

        $responseSeller->assertForbidden();
        $responseSeller->assertDontSee(__("BRANDS"));
    }

    public function test_non_admin_cannot_access_brand_lists_page_without_query_parameters(): void
    {
        $responseUser = $this->actingAs($this->user)->get("/admin/brands");
        $responseSeller = $this->actingAs($this->seller)->get("/admin/brands");

        $responseUser->assertForbidden();
        $responseUser->assertDontSee(__("BRANDS"));

        $responseSeller->assertForbidden();
        $responseSeller->assertDontSee(__("BRANDS"));
    }

    public function test_admin_with_brand_menu_permission_can_access_brand_lists_page_with_pagination_and_query_parameters(): void
    {
        $response = $this->actingAs($this->adminWithPermission(permission:$this->createBrandPermission("brand.menu")))
                         ->get("/admin/brands?page=1&per_page=10&sort=id&direction=desc");

        $response->assertOk();
        $response->assertSee(__("BRANDS"));
    }

    public function test_admin_with_brand_menu_permission_can_access_brand_lists_page_without_query_parameters(): void
    {
        $response = $this->actingAs($this->adminWithPermission(permission:$this->createBrandPermission("brand.menu")))
                         ->get("admin/brands");

        $response->assertOk();
        $response->assertSee(__("BRANDS"));
    }

    // public function test_brand_lists_page_contains_empty_table(): void
    // {
    //     $response = $this->actingAs($this->adminWithPermission(permission:$this->createBrandPermission("brand.menu")))
    //                      ->get("admin/brands?page=1&per_page=10&sort=id&direction=desc");

    //     $response->assertOk();
    //     $response->assertSee(__("DATA_IS_NOT_AVALIABLE_FOR_THIS_TABLE"));
    // }

    // public function test_brand_lists_page_contains_non_empty_table(): void
    // {
    //     Brand::factory(10)->create();

    //     $response = $this->actingAs($this->adminWithPermission(permission:$this->createBrandPermission("brand.menu")))
    //                      ->get("admin/brands?per_page=10&sort=id&direction=desc");

    //     $response->assertOk();
    //     $response->assertDontSee(__("DATA_IS_NOT_AVALIABLE_FOR_THIS_TABLE"));
    // }

    // public function test_admin_with_brand_add_permission_can_see_add_brand_button_in_brand_lists_page()
    // {

    //     $this->adminWithPermission(permission:$this->createBrandPermission("brand.menu"));

    //     $response = $this->actingAs($this->adminWithPermission(permission:$this->createBrandPermission("brand.add")))
    //                      ->get("/admin/brands?page=1&per_page=10&sort=id&direction=desc");

    //     $response->assertSee(__("ADD_BRAND"));
    //     $response->assertOk();
    // }

    private function createUser(string $role = "user"): User
    {
        return User::factory()->create(["role" => $role,"deleted_at" => null]);
    }

    private function createBrandPermission(string $permissionName)
    {
        $permission = Permission::create(["name" => $permissionName,"group" => "brand"]);

        return $permission->name;
    }

    private function adminWithPermission(string $permission)
    {
        $this->admin->givePermissionTo($permission);

        return $this->admin;
    }

}
