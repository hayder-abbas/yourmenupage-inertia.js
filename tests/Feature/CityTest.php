<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class CityTest extends TestCase
{
    public function test_cities_page_renders_with_expected_props(): void
    {
        $response = $this->get(route('cities.index'));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('City/Index')
                ->has('cities')
        );
    }
}
