<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    }


    public function test_dashboard_page_renders_with_expected_props(): void
    {
        $response = $this->get('/dashboard');

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Dashboard')
                ->has('restaurant')
        );
    }


    public function test_trash_renders_with_expected_props(): void
    {
        $response = $this->get('/items/trashed');

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Item/Trashed')
                ->has('trashedItems')
        );
    }
}
