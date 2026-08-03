<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class RestaurantTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected City $city;
    protected Restaurant $restaurant;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->city = City::factory()->create();
        $this->restaurant = Restaurant::factory()
            ->for($this->user)
            ->for($this->city)
            ->create(['user_id' => $this->user->id]);
        $this->actingAs($this->user);
    }


    public function test_show_restaurant_page_renders_with_expected_props(): void
    {
        $response = $this->get(route('restaurants.show', [
            'restaurant' => $this->restaurant
        ]));

        $response->assertOk();
        $response->assertInertia(
            fn(Assert $page) => $page
                ->component('Restaurant/Show')
                ->has('restaurant')
                ->has('items')
                ->has('categories')
                ->has('can')
        );
    }


    public function test_restaurant_information_can_be_updated(): void
    {
        $response = $this
            ->from(route('restaurants.edit', [
                'restaurant' => $this->restaurant
            ]))
            ->patch(
                route('restaurants.update', [
                    'restaurant' => $this->restaurant
                ]),
                [
                    'rest_name' => 'Test Restaurant',
                    'rest_phone' => '+1 (915) 668-7814',
                    'location' => 'Id cupidatat eum id',
                    'open_at' => '02:00',
                    'close_at' => '20:00',
                    'user_id' => $this->user->id,
                    'city_id' => $this->city->id
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('restaurants.show', [
                'restaurant' => $this->restaurant
            ]));

        $this->restaurant->refresh();
        $this->assertSame('Test Restaurant', $this->restaurant->rest_name);
    }


    public function test_user_can_delete_their_restaurant(): void
    {
        $response = $this
            ->from(route('restaurants.edit', [
                'restaurant' => $this->restaurant
            ]))
            ->delete(route('restaurants.destroy', [
                'restaurant' => $this->restaurant
            ]), [
                'password' => 'password',
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertNull($this->restaurant->fresh());
    }


    public function test_correct_password_must_be_provided_to_delete_restaurant(): void
    {
        $response = $this
            ->from(route('restaurants.edit', [
                'restaurant' => $this->restaurant
            ]))
            ->delete(route('restaurants.destroy', [
                'restaurant' => $this->restaurant
            ]), [
                'password' => 'wrong-password',
            ]);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect(route('restaurants.edit', [
                'restaurant' => $this->restaurant
            ]));

        $this->assertNotNull($this->restaurant->fresh());
    }
}
