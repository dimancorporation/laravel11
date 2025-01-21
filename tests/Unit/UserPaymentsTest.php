<?php

namespace Tests\Unit;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase;

class UserPaymentsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test to verify that the payments relationship returns the expected payments.
     */
    public function testPaymentsRelationshipReturnsAssociatedPayments(): void
    {
        // Create a user
        $user = User::factory()->create();

        // Create associated payment records for the user
        $payments = Payment::factory()->count(2)->create(['user_id' => $user->id]);

        // Assert the payments relationship contains the created payments
        $this->assertCount(2, $user->payments);
        $this->assertTrue($user->payments->contains($payments[0]));
        $this->assertTrue($user->payments->contains($payments[1]));
    }

    /**
     * Test to verify that the payments relationship returns an empty collection if no associated payments exist.
     */
    public function testPaymentsRelationshipReturnsEmptyCollectionWhenNoPaymentsExist(): void
    {
        // Create a user without any payments
        $user = User::factory()->create();

        // Assert the payments relationship is an empty collection
        $this->assertCount(0, $user->payments);
        $this->assertTrue($user->payments->isEmpty());
    }

    /**
     * Test to ensure payments relationship does not include payments from other users.
     */
    public function testPaymentsRelationshipExcludesPaymentsFromOtherUsers(): void
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        // Create a payment for user1
        $payment = Payment::factory()->create(['user_id' => $user1->id]);

        // Assert that user2 does not contain user1's payment
        $this->assertCount(0, $user2->payments);
        $this->assertFalse($user2->payments->contains($payment));
    }
}
