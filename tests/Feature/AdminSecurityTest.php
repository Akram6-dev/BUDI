<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_admin_api_endpoints(): void
    {
        // Unauthenticated request to /api/teachers should return 401
        $response = $this->getJson('/api/teachers');
        $response->assertStatus(401);
        $response->assertJson([
            'success' => false,
            'message' => 'Unauthorized. Silakan login sebagai admin.'
        ]);

        // Unauthenticated request to /api/students should return 401
        $response = $this->getJson('/api/students');
        $response->assertStatus(401);

        // Unauthenticated request to /api/classes should return 401
        $response = $this->getJson('/api/classes');
        $response->assertStatus(401);

        $response = $this->getJson('/api/instansi');
        $response->assertStatus(401);

        $response = $this->getJson('/api/sekolah');
        $response->assertStatus(401);

        // Unauthenticated delete request should return 401
        $response = $this->deleteJson('/api/data/1');
        $response->assertStatus(401);
    }

    public function test_guest_cannot_access_admin_dashboard(): void
    {
        $response = $this->get('/admin/dashboard');
        $response->assertRedirect('/login');

        $response = $this->get('/admin/export-pdf');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_admin_can_access_dashboard_and_apis(): void
    {
        $response = $this->withSession([
            'admin_logged_in' => true,
            'admin_username'  => 'admin',
        ])->get('/admin/dashboard');

        $response->assertStatus(200);

        $apiResponse = $this->withSession([
            'admin_logged_in' => true,
            'admin_username'  => 'admin',
        ])->getJson('/api/instansi');

        $apiResponse->assertStatus(200);
        $apiResponse->assertJsonStructure(['count', 'data']);

        $apiResponse2 = $this->withSession([
            'admin_logged_in' => true,
            'admin_username'  => 'admin',
        ])->getJson('/api/sekolah');

        $apiResponse2->assertStatus(200);
        $apiResponse2->assertJsonStructure(['count', 'data']);
    }
}
