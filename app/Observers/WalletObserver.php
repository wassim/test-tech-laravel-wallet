<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Wallet;
use App\Notifications\BalanceLow;

class WalletObserver
{
    /**
     * Handle the Wallet "updated" event.
     */
    public function updated(Wallet $wallet): void
    {
        if ($wallet->isDirty('balance') && $wallet->balance < Wallet::LOW_BALANCE_TREASHOLD) {
            $wallet->user->notify(new BalanceLow($wallet));
        }
    }
}
