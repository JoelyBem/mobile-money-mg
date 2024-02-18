<?php

declare(strict_types=1);

namespace MobileMoneyMG;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}