<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateAuthDataEvent
{
    use Dispatchable, SerializesModels;

    public int $dealId;
    public string $phone;
    public string $password;

    /**
     * Create a new event instance.
     *
     * @param int $dealId
     * @param string $phone
     * @param string $password
     */
    public function __construct(int $dealId, string $phone, string $password)
    {
        $this->dealId = $dealId;
        $this->phone = $phone;
        $this->password = $password;
    }
}
