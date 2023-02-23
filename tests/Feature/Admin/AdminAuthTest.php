<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_login_screen_can_be_rendered(): void
    {
        $response = $this->get('admin/login');

        $response->assertStatus(200);
    }

    public function test_authenticated_admin_redirect_to_admin_dashboard()
    {
        User::create([
            "name"=>"Admin User",
            "email"=>"admin@gmail.com",
            "password"=>bcrypt("Password!"),
            "role"=>"admin"
        ]);


        $response=$this->post('/login', [
            "email"=>"admin@gmail.com",
            "password"=>"Password!"
        ]);


        $response->assertStatus(302);
        $response->assertRedirect("admin/dashboard");
    }

    public function test_unauthenticated_admin_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('admin/dashboard');

        $response->assertStatus(302);

        $response->assertRedirect("/login");
    }
}
