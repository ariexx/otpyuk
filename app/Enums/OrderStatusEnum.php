<?php

namespace App\Enums;

enum OrderStatusEnum: int
{
    case REPEAT = 0;
    case PROCESSING = 1;
    case COMPLETED = 2;
    case CANCELED = 3;
    case PENDING = 4;
}
