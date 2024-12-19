<?php

namespace Tests\Unit;

use App\Http\Controllers\Auth\PasswordSetupController;
use App\Http\Requests\PasswordSetupRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Tests\TestCase;

/**
 * Class PasswordSetupControllerTest
 *
 * Test cases for the update method in the PasswordSetupController class
 *
 * @package Tests\Http\Controllers\Auth
 */
class PasswordSetupControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Tests the update function of the PasswordSetupController
     *
     * @return void
     */
    public function testUpdate(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);
        $this->be($user);

        $request = \Mockery::mock(PasswordSetupRequest::class);
        $request->shouldReceive('validated')->andReturn([
            'current_password' => 'password',
            'password' => 'TestPassword123',
            'password_confirmation' => 'TestPassword123',
            'email' => 'test@example.com',
        ]);
        $request->shouldReceive('user')->andReturn($user);

        $controller = new PasswordSetupController();

        $response = $controller->update($request);
        $this->assertEquals(302, $response->getStatusCode());

        $updatedUser = $user->refresh();
        $this->assertTrue(Hash::check('TestPassword123', $updatedUser->password));

        $this->assertEquals('test@example.com', $updatedUser->email);

        $this->assertFalse($updatedUser->is_first_auth);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(Route('dashboard'), $response->getTargetUrl());
    }
}
