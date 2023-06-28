<?php

namespace App\Providers;

use App\Events\AccountDeleted;
use App\Listeners\AccountDeleted\SendConfirmOfAccountDeletionEmailToUser;
use App\Listeners\AccountDeleted\SendUserAccountDeletedEmailNotificationToAdmin;
use App\Listeners\AccountDeleted\SendUserAccountDeletedNotificationToAdminDashboard;
use App\Listeners\AccountRegistered\SendNewUserRegisteredEmailNotificationToAdmin;
use App\Listeners\AccountRegistered\SendNewUserRegisteredNotificationToAdminDashboard;
use App\Listeners\AccountRegistered\SendWelcomeEmailToRegisteredUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
            SendNewUserRegisteredNotificationToAdminDashboard::class,
            SendNewUserRegisteredEmailNotificationToAdmin::class,
            SendWelcomeEmailToRegisteredUser::class,
        ],
        AccountDeleted::class=>[
            SendUserAccountDeletedNotificationToAdminDashboard::class,
            SendUserAccountDeletedEmailNotificationToAdmin::class,
            SendConfirmOfAccountDeletionEmailToUser::class,
        ]
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
