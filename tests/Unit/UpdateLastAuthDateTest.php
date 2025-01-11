<?php

namespace Tests\Unit;

use App\Events\UpdateLastAuthDate;
use App\Listeners\UpdateLastAuthDateListener;
use App\Models\B24UserField;
use App\Models\User;
use App\Providers\BitrixServiceProvider;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Config;
use Mockery;
use PHPUnit\Runner\Exception;
use Tests\TestCase;

class UpdateLastAuthDateTest extends TestCase
{
    use RefreshDatabase;

//    protected function setUp(): void
//    {
//        parent::setUp();
//
//        Config::set('bitrix.webhook_url', 'https://b24-aiahsd.bitrix24.ru/rest/9/5cezao9v9yklbnfy');
//
//        $this->app->register(BitrixServiceProvider::class);
//        $this->seed(DatabaseSeeder::class);
//    }
//    public function testHandleUpdatesLastAuthDateForNonAdmin()
//    {
//        // Mock dependencies
//        $serviceBuilderMock = Mockery::mock();
//        $crmScopeMock = Mockery::mock();
//        $dealMock = Mockery::mock();
//
//        $serviceBuilderMock->shouldReceive('getCRMScope')->andReturn($crmScopeMock);
//        $crmScopeMock->shouldReceive('deal')->andReturn($dealMock);
//
//        $this->app->instance('ServiceBuilder', $serviceBuilderMock);
//
//        // Create a user
//        $user = User::factory()->create(['role' => 'user', 'id_b24' => '2']);
//
//        // Mock Carbon for consistent timestamps
//        Carbon::setTestNow('2024-12-21 15:30:00');
//
//        // Trigger the event listener
//        $listener = new UpdateLastAuthDateListener();
//        $listener->handle(new UpdateLastAuthDate($user));
//
//        // Expect the CRM update to be called with the correct data
//        $dealMock->shouldReceive('update')->with('2', [
//            'UF_CRM_1715524078722' => '21.12.2024 15:30:00',
//        ])->once();
//
//        Carbon::setTestNow(); // Reset Carbon
//    }
//
//    public function testHandleSkipsUpdateForAdmin()
//    {
//        // Mock dependencies
//        $serviceBuilderMock = Mockery::mock();
//        $this->app->instance('ServiceBuilder', $serviceBuilderMock);
//
//        // Create an admin user
//        $user = User::factory()->make(['role' => 'Admin']);
//
//        // Ensure the service builder is not called
//        $serviceBuilderMock->shouldNotReceive('getCRMScope');
//
//        // Trigger the event listener
//        $listener = new UpdateLastAuthDateListener();
//        $listener->handle(new UpdateLastAuthDate($user));
//    }
}
