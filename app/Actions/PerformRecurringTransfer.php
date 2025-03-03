<?php

declare(strict_types=1);

namespace App\Actions;

use App\Exceptions\InsufficientBalance;
use App\Models\RecurringTransfer;
use App\Models\User;

readonly class PerformRecurringTransfer
{
    public function __construct(protected PerformWalletTransfer $performWalletTransfer)
    {

    }

    public function execute(RecurringTransfer $recurringTransfer): void
    {
        $sender = $recurringTransfer->user;
        $recipient = User::where('email', $recurringTransfer->recipient_email)->first();

        try {
            $this->performWalletTransfer->execute(
                sender: $sender,
                recipient: $recipient,
                amount: $recurringTransfer->amount,
                reason: $recurringTransfer->reason = ''
            );

            // Schedule transfer
        } catch (InsufficientBalance $exception) {
            $recurringTransfer->update(['status' => ''])
        }
    }

    public function scheduleNext(RecurringTransfer $recurringTransfer): void
    {
        $nextDate = now()->addDays($recurringTransfer->frequency);

        if ($nextDate->isAfter($recurringTransfer->end_date)) {
            // transfer completed
        }

        $nextExecution = $nextDate->copy()->startOfDay()->addHours(2);

        $recurringTransfer->next_execution = $nextExecution;

        $recurringTransfer->save();
    }
}
