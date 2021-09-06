<?php

namespace App\Listeners;

use App\Events\EmailResetRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Http\Proxy\Email;

class EmailResetLink
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
    public function handle(EmailResetRequest $event)
    {
        $this->emailProxy->SendEmailResetLink($event->token, $event->payload);

        $this->emailProxy->SendEmailResendUsername($event->token, $event->payload);
    }
}
