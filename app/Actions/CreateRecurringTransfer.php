<?php

declare(strict_types=1);

namespace App\Actions;

use App\Models\RecurringTransfer;

readonly class CreateRecurringTransfer
{
    public function execute(array $data): RecurringTransfer
    {
        return request()->user()->recurringTransfers()->create($data);
    }
}
