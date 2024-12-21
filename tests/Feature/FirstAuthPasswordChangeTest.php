<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class FirstAuthPasswordChangeTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanChangePasswordOnFirstAuth()
    {
        $user = User::factory()->create([
            'is_first_auth' => true,
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/password/setup', [
            'email' => 'some-test@email.com',
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHasNoErrors();

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
        $this->assertFalse($user->is_first_auth);
    }

    public function testUserCannotChangePasswordWithInvalidCurrentPassword()
    {
        $user = User::factory()->create([
            'is_first_auth' => true,
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/password/setup', [
            'current_password' => 'wrongpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertSessionHasErrors(['current_password']);
        $this->assertTrue($user->is_first_auth);
    }

    public function testUserCannotChangePasswordIfPasswordsDoNotMatch()
    {
        $user = User::factory()->create([
            'is_first_auth' => true,
            'password' => Hash::make('oldpassword'),
        ]);

        $this->actingAs($user);

        $response = $this->post('/password/setup', [
            'current_password' => 'oldpassword',
            'password' => 'newpassword123',
            'password_confirmation' => 'differentpassword',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertTrue($user->is_first_auth);
    }
}
