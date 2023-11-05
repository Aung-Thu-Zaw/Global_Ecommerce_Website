<?php

namespace Tests\Unit\ServiceClasses;

use App\Models\User;
use App\Services\ReadNotificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class ReadNotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_read_notification_marks_notification_as_read(): void
    {
        // Arrange
        $user = User::factory()->create();
        $notification = $user->notifications()->create([
            'id' => Str::uuid(),
            'data' => 'Your notification data',
            'type' => 'App\Notifications\TestingNotification',
        ]);

        // Act
        $service = new ReadNotificationService();
        $service->read($notification->notifiable_id, $notification->id);

        // Assert
        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_readAll_marks_all_notifications_as_read(): void
    {
        // Arrange
        $user = User::factory()->create();
        $notifications = $user->notifications()->createMany([
            [
                'id' => Str::uuid(),
                'data' => 'Your notification data 1',
                'type' => 'App\Notifications\TestingNotification',
            ],
            [
                'id' => Str::uuid(),
                'data' => 'Your notification data 2',
                'type' => 'App\Notifications\TestingNotification',
            ],
            [
                'id' => Str::uuid(),
                'data' => 'Your notification data 3',
                'type' => 'App\Notifications\TestingNotification',
            ],
        ]);

        // Act
        $service = new ReadNotificationService();
        $service->readAll($notifications->toArray());

        // Assert
        foreach ($notifications as $notification) {
            $this->assertNotNull($user->notifications()->find($notification->id)->read_at);
        }
    }
}
