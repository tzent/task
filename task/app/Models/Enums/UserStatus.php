<?php

declare(strict_types=1);

namespace App\Models\Enums;

enum UserStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;
}
