<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TransactionSuccessful extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
public $email_payload;
public $token;
public $type;

    public function __construct($Token, $Email_payload, $type)
    {
        $this->token = $Token;
        $this->type = $type;
        $this->email_payload = $Email_payload;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
