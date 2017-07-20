<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;
use App\Events\FileUploadedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UploadSuccessMailListener
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
     * @param  FileUploadedEvent  $event
     * @return void
     */
    public function handle(FileUploadedEvent $event)
    {   
        Log::info('This is the data from img upload\n\n'.json_encode($event->img));
    }
}
