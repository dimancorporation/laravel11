<?php

namespace Tests\Unit;

use App\Models\User;
use App\Services\PaymentService;
use Error;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Http\Request;
use Mockery;

class UserPaymentsServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the createPayment method with valid user and request data.
     */
    public function testCreatePaymentWithValidData(): void
    {
        $user = User::factory()->create();
        $request = Request::create('/create-payment', 'POST', [
            'OrderId' => '123',
            'PaymentId' => '456',
            'Success' => true,
            'Status' => 'completed',
            'Amount' => 1000,
            'CardId' => 12,
            'Data' => [
                'Email' => $user->email,
                'Name' => 'John Doe',
                'Phone' => '9876543210',
                'Source' => 'web',
                'user_agent' => 'Mozilla/5.0',
            ],
        ]);

        $paymentService = Mockery::mock(PaymentService::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $paymentService->shouldReceive('findUser')->with($request)->andReturn($user);

        $paymentService->createPayment($request);

        $this->assertDatabaseHas('payments', [
            'b24_deal_id' => $user->id_b24,
            'b24_contact_id' => $user->contact_id,
            'order_id' => '123',
            'success' => true,
            'status' => 'completed',
            'payment_id' => '456',
            'amount' => 100 / 10,
            'card_id' => 12,
            'email' => $user->email,
            'name' => 'John Doe',
            'phone' => '+79876543210',
            'source' => 'web',
            'user_agent' => 'Mozilla/5.0',
        ]);
    }

    /**
     * Test the createPayment method when no user is found.
     */
    public function testCreatePaymentWithNoUserFound(): void
    {
        $request = Request::create('/create-payment', 'POST', [
            'OrderId' => '123',
            'PaymentId' => '456',
            'Success' => true,
            'Status' => 'completed',
            'Amount' => 1000,
            'CardId' => 12,
            'Data' => [
                'Email' => 'nonexistent@example.com',
                'Name' => 'John Doe',
                'Phone' => '1234567890',
                'Source' => 'web',
                'user_agent' => 'Mozilla/5.0',
            ],
        ]);

        $paymentService = Mockery::mock(PaymentService::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $paymentService->shouldReceive('findUser')->with($request)->andReturn(null);

        $this->expectException(Error::class);

        $paymentService->createPayment($request);

        $this->assertDatabaseMissing('payments', [
            'order_id' => '123',
        ]);
    }

    /**
     * Test the createPayment method with missing request parameters.
     */
    public function testCreatePaymentWithMissingRequestParameters(): void
    {
        $user = User::factory()->create();
        $request = Request::create('/create-payment', 'POST', [
            'OrderId' => '123',
            'Data' => [
                'Phone' => '0987654321',
                'Source' => 'web',
                'user_agent' => 'Mozilla/5.0',
            ],
        ]);

        $paymentService = Mockery::mock(PaymentService::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $paymentService->shouldReceive('findUser')->with($request)->andReturn($user);

        $this->expectException(Error::class);

        $paymentService->createPayment($request);

        $this->assertDatabaseMissing('payments', [
            'order_id' => '123',
        ]);
    }
}
