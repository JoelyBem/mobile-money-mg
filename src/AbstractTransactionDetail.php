<?php

declare(strict_types=1);

namespace MobileMoneyMG;

abstract class AbstractTransactionDetail
{
    public int $amount;
    public string $reference;
    public string $status;
    public \DateTimeImmutable $date;
    public string $debitPhoneNumber;
    public string $creditPhoneNumber;
    public int $fee;
}