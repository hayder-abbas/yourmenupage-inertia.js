<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\City;
use App\Models\Item;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected City $city;
    protected Category $category;
    protected Restaurant $restaurant;
    protected Item $item;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->city = City::factory()->create();
        $this->category = Category::factory()->create();
        $this->restaurant = Restaurant::factory()
            ->for($this->user)
            ->for($this->city)
            ->create(['user_id' => $this->user->id]);
        $this->item = Item::factory()
            ->for($this->category)
            ->for($this->restaurant)
            ->create();
        $this->actingAs($this->user);
    }


    public function test_user_can_create_new_item()
    {
        $response = $this
            ->from(route('restaurants.show', [
                'restaurant' => $this->restaurant
            ]))
            ->post(route('items.store'), [
                'item_title' => 'Test Item',
                'item_desc' => 'Test item description',
                'item_price' => '1000',
                'restaurant_id' => $this->restaurant->id,
                'category_id' => $this->category->id,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('restaurants.show', [
                'restaurant' => $this->restaurant
            ]));
    }


    public function test_item_information_can_be_updated()
    {
        $response = $this
            ->from(route('items.edit', [
                'item' => $this->item
            ]))
            ->patch(route('items.update', [
                'item' => $this->item
            ]), [
                'item_title' => 'Test Item',
                'item_desc' => 'Test item description',
                'item_price' => '1000',
                'restaurant_id' => $this->restaurant->id,
                'category_id' => $this->category->id,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('restaurants.show', [
                'restaurant' => $this->restaurant
            ]));

        $this->item->refresh();
        $this->assertSame('Test Item', $this->item->item_title);
    }


    public function test_user_can_trash_their_item()
    {
        $response = $this
            ->from(route('restaurants.show', [
                'restaurant' => $this->restaurant
            ]))
            ->delete(route('items.destroy', [
                'item' => $this->item
            ]));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('restaurants.show', [
                'restaurant' => $this->restaurant
            ]));

        $this->assertNotNull($this->item->fresh());
    }


    public function test_user_can_force_delete_their_item()
    {
        $response = $this
            ->from(route('items.trashed'))
            ->delete(route('items.forceDelete', [
                'item' => $this->item
            ]));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('items.trashed'));

        $this->assertNull($this->item->fresh());
    }


    public function test_user_can_restore_their_item()
    {
        $response = $this
            ->from(route('items.trashed'))
            ->patch(route('items.restore', [
                'item' => $this->item
            ]));

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('items.trashed'));
    }
}
