<?php

namespace Tests\Unit;

use App\Http\Middleware\FirstAuthMiddleware;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Mockery;
use Tests\TestCase;

class FirstAuthRedirectTest extends TestCase
{
    use RefreshDatabase;

    /** @var FirstAuthMiddleware */
    private FirstAuthMiddleware $middleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->middleware = new FirstAuthMiddleware();
    }

    public function testHandleUserIsFirstAuth()
    {
        $user = User::factory()->create(['is_first_auth' => true]);
        Auth::shouldReceive('user')->andReturn($user);

        $request = Mockery::mock(Request::class);

        $next = function () {
            return response('OK');
        };

        $response = $this->middleware->handle($request, $next);

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(302, $response->getStatusCode());
        $this->assertStringContainsString('/password/setup', $response->headers->get('Location'));
    }

    public function testHandleUserIsNotFirstAuth()
    {
        $user = User::factory()->create(['is_first_auth' => false]);
        Auth::shouldReceive('user')->andReturn($user);

        $request = Request::create('/test-route', 'GET');

        $next = function () {
            return \response('This is a test response');
        };

        $response = $this->middleware->handle($request, $next);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('This is a test response', $response->getContent());
    }
}
