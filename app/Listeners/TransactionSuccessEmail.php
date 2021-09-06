<?php

namespace App\Listeners;


use App\Events\TransactionSuccessful;
use App\Http\Proxy\Email;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransactionSuccessEmail
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
     * @param  TransactionSuccessful  $event
     * @return void
     */
    public function handle(TransactionSuccessful $event)
    {
        $this->emailProxy->SendTransactionSuccessful($event->token, $event->email_payload, $event->type);
    }
}
