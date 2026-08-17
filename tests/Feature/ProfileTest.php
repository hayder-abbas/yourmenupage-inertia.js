<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        Storage::fake('public');
    }


    public function test_profile_page_is_displayed(): void
    {
        $response = $this->get('/profile');
        $response->assertOk();
    }

    public function test_profile_information_can_be_updated(): void
    {
        $response = $this->patch('/profile', [
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'test@example.com',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        $this->user->refresh();

        $this->assertSame('First name', $this->user->first_name);
        $this->assertSame('test@example.com', $this->user->email);
        $this->assertNull($this->user->email_verified_at);
    }

    public function test_email_verification_status_is_unchanged_when_the_email_address_is_unchanged(): void
    {
        $response = $this->patch('/profile', [
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => $this->user->email,
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');
        $this->assertNotNull($this->user->refresh()->email_verified_at);
    }

    public function test_user_can_delete_their_account(): void
    {
        $response = $this->delete('/profile', [
            'password' => 'password',
        ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/login');

        $this->assertGuest();
        $this->assertNull($this->user->fresh());
    }

    public function test_correct_password_must_be_provided_to_delete_account(): void
    {
        $response = $this
            ->from('/profile')
            ->delete('/profile', ['password' => 'wrong-password']);

        $response
            ->assertSessionHasErrors('password')
            ->assertRedirect('/profile');

        $this->assertNotNull($this->user->fresh());
    }

    public function test_user_image_can_be_uploaded(): void
    {
        $file = UploadedFile::fake()->image('user.jpg');

        $response = $this
            ->from('/profile')
            ->patch('/profile', [
                'first_name' => 'First name',
                'last_name' => 'Last name',
                'email' => 'test@example.com',
                'user_image' => $file,
            ]);

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');

        $this->assertTrue(
            Storage::disk('public')->exists('user_image/' . $file->hashName())
        );
    }

    public function test_reset_profile_image()
    {
        $response = $this
            ->from('/profile')
            ->post('/reset/profile/image');

        $response->assertSessionHasNoErrors()->assertRedirect('/profile');
        $this->assertNull($this->user->refresh()->user_image);
    }
}
