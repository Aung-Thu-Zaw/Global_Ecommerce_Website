<?php

namespace App\Providers;

use App\Events\ChatMessage;
use App\Listeners\HandleChatMessage;
use App\Listeners\RegisteredUserListener;
use App\Listeners\Registered\SendNewUserRegisteredEmailNotificationForAdmin;
use App\Listeners\Registered\SendNewUserRegisteredNotificationForAdminDashboard;
use App\Listeners\Registered\SendWelcomeEmailToRegisteredAccount;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendNewUserRegisteredNotificationForAdminDashboard::class,
            SendNewUserRegisteredEmailNotificationForAdmin::class,
            SendWelcomeEmailToRegisteredAccount::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
