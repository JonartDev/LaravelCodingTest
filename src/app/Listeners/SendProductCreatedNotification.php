<?php

namespace App\Listeners;

use App\Events\ProductCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductCreatedMail;

class SendProductCreatedNotification implements ShouldQueue
{
    public function handle(ProductCreated $event)
    {
        $user = $event->product->user;
        Mail::to($user->email)->send(new ProductCreatedMail($event->product));
    }
}