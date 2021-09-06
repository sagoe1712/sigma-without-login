<?php

namespace App\Listeners;

use App\Events\EmailResetConfirm;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Proxy\Email;

class PasswordResetConfirm
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private $emailProxy;
    public function __construct(Email $EmailProxy)
    {
        $this->emailProxy = $EmailProxy;
    }

    /**
     * Handle the event.
     *
     * @param  EmailResetRequest  $event
     * @return void
     */
    public function handle(EmailResetConfirm $event)
    {
        $this->emailProxy->SendEmailResetSuccess($event->token, $event->payload);
    }
}
