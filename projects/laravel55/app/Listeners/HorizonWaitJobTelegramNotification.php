<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Telegram;

class HorizonWaitJobTelegramNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Telegram::sendMessage(
            'error',
            sprintf('[<strong>%s</strong>] The <strong>"%s"</strong> queue on the <strong>"%s"</strong> connection has a wait time of <strong>%s</strong> seconds.', config('app.name'), $event->queue, $event->connection, $event->seconds)
        );
    }
}
