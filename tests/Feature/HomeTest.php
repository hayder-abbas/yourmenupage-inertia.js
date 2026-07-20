<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class HomeTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected City $city;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->city = City::factory()->create();
    }

    private function makeRestaurant(array $attributes = []): Restaurant
    {
        return Restaurant::factory()
            ->for($this->user)
            ->for($this->city)
            ->create($attributes);
    }

    public function test_home_page_renders_with_expected_props(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Home')
                ->has('canLogin')
                ->has('canRegister')
                ->has('restaurants')
                ->has('filters')
        );
    }


    public function test_search_matches_partial_names_anywhere_in_the_string(): void
    {
        $this->makeRestaurant(['rest_name' => 'The Golden Dragon']);
        $this->makeRestaurant(['rest_name' => 'Golden Corral']);
        $this->makeRestaurant(['rest_name' => 'Silver Spoon']);

        $response = $this->get(route('home', ['search' => 'Golden']));

        $response->assertInertia(fn(Assert $page) => $page->has('restaurants', 2));
    }


    public function test_search_is_case_insensitive(): void
    {
        $this->makeRestaurant(['rest_name' => 'Pizza Palace']);

        $response = $this->get(route('home', ['search' => 'pizza palace']));

        $response->assertInertia(fn(Assert $page) => $page->has('restaurants', 1));
    }


    public function test_it_returns_an_empty_list_when_nothing_matches(): void
    {
        $this->makeRestaurant(['rest_name' => 'Pizza Palace']);

        $response = $this->get(route('home', ['search' => 'Nonexistent Restaurant']));

        $response->assertInertia(fn(Assert $page) => $page->has('restaurants', 0));
    }
}
