<?php

namespace App\Providers;

use App\Events\AccountDeleted;
use App\Events\RegisteredWithSocialite;
use App\Events\SubscribedNewsletter;
use App\Events\SuggestionForWebsite;
use App\Listeners\AccountDeleted\SendConfirmOfAccountDeletionEmailToUser;
use App\Listeners\AccountDeleted\SendUserAccountDeletedEmailNotificationToAdmin;
use App\Listeners\AccountDeleted\SendUserAccountDeletedNotificationToAdminDashboard;
use App\Listeners\AccountRegistered\SendNewUserRegisteredEmailNotificationToAdmin;
use App\Listeners\AccountRegistered\SendNewUserRegisteredNotificationToAdminDashboard;
use App\Listeners\AccountRegistered\SendWelcomeEmailToRegisteredUser;
use App\Listeners\AccountRegisteredWithSocialite\SendNewUserRegisteredWithSocialiteEmailNotificationToAdmin;
use App\Listeners\AccountRegisteredWithSocialite\SendNewUserRegisteredWithSocialiteNotificationToAdminDashboard;
use App\Listeners\AccountRegisteredWithSocialite\SendWelcomeEmailToRegisteredWithSocialiteUser;
use App\Listeners\SubscribedNewsletter\SendNewSubscriberEmailNotificationToAdmin;
use App\Listeners\SubscribedNewsletter\SendNewSubscriberNotificationToAdminDashboard;
use App\Listeners\SubscribedNewsletter\SendThankForSubscribeWebsiteEmailToSubscriber;
use App\Listeners\WebsiteSuggestion\SendNewSuggestionEmailNotificationToAdmin;
use App\Listeners\WebsiteSuggestion\SendNewSuggestionNotificationToAdminDashboard;
use App\Listeners\WebsiteSuggestion\SendThankForSuggestionEmailToSuggestionSubmitter;
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
        RegisteredWithSocialite::class => [
            SendNewUserRegisteredWithSocialiteNotificationToAdminDashboard::class,
            SendNewUserRegisteredWithSocialiteEmailNotificationToAdmin::class,
            SendWelcomeEmailToRegisteredWithSocialiteUser::class,
        ],
        AccountDeleted::class=>[
            SendUserAccountDeletedNotificationToAdminDashboard::class,
            SendUserAccountDeletedEmailNotificationToAdmin::class,
            SendConfirmOfAccountDeletionEmailToUser::class,
        ],
        SubscribedNewsletter::class=>[
            SendNewSubscriberNotificationToAdminDashboard::class,
            SendNewSubscriberEmailNotificationToAdmin::class,
            SendThankForSubscribeWebsiteEmailToSubscriber::class,
        ],
        SuggestionForWebsite::class=>[
            SendNewSuggestionNotificationToAdminDashboard::class,
            SendNewSuggestionEmailNotificationToAdmin::class,
            SendThankForSuggestionEmailToSuggestionSubmitter::class,
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
