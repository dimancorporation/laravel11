<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateLastAuthDateTime
{
    use Dispatchable, SerializesModels;

    public User $user;
    public string $userIP;

    public function __construct($user, $userIP)
    {
        $this->user = $user;
        $this->userIP = $userIP;
    }
}
