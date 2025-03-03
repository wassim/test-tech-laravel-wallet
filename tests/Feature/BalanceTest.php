<?php

declare(strict_types=1);

use App\Models\User;
use App\Models\Wallet;
use App\Notifications\BalanceLow;
use Illuminate\Support\Facades\Notification;

describe('balance notifications', function () {
    test('notifications are sent when balance is low', function () {
        Notification::fake();

        $user = User::factory()->has(Wallet::factory())->create();
        $wallet = $user->wallet;

        // Assert that no notifications were sent...
        Notification::assertNothingSent();

        $wallet->forceFill(['balance' => 5])->save();

        // Assert a notification was sent to the given users...
        Notification::assertSentTo(
            [$user],
            BalanceLow::class
        );

        // Assert that a given number of notifications were sent...
        Notification::assertCount(1);
    });

    test('notifications are not sent when balance is not low', function () {
        Notification::fake();

        $user = User::factory()->has(Wallet::factory())->create();
        $wallet = $user->wallet;

        // Assert that no notifications were sent...
        Notification::assertNothingSent();

        $wallet->forceFill(['balance' => 10])->save();

        // Assert that no notifications were sent...
        Notification::assertNothingSent();

        // Assert that a given number of notifications were sent...
        Notification::assertCount(0);
    });
});
