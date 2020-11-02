<?php

namespace App\Providers;

use App\Events\CreateOrder as EventCreateOrder;
use App\Events\CreateTransactionState as EventCreateTransactionState;
use App\Listeners\CreateOrder;
use App\Listeners\CreateTransactionState;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        EventCreateOrder::class => [
            CreateOrder::class,
        ],
        EventCreateTransactionState::class => [
            CreateTransactionState::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot()
    {
    }
}
