<?php

declare(strict_types=1);

namespace App\Enums;

enum RecurringTransferStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
