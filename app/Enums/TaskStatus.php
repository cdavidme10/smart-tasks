<?php

namespace App\Enums;

use App\Traits\ProvidesEnumValues;

enum TaskStatus: string
{
    use ProvidesEnumValues;

    case Pending = 'pending';
    case InProgress = 'in-progress';
    case OnHold = 'on-hold';
    case Cancelled = 'cancelled';
    case Completed = 'completed';
}
