<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class AboutusTest extends TestCase
{
    public function test_about_us_page_renders(): void
    {
        $response = $this->get(route('about'));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('About')
        );
    }
}
