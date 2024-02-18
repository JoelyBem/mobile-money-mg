<?php

declare(strict_types=1);

namespace MobileMoneyMG\MVola;

use MobileMoneyMG\AbstractTransactionDetail;

class TransactionDetail extends AbstractTransactionDetail
{

    public function __construct(int $amount, string $reference, string $status, \DateTimeImmutable $date, string $debitPhoneNumber, string $creditPhoneNumber, int $fee)
    {
        $this->amount = $amount;
        $this->reference = $reference;
        $this->status = $status;
        $this->date = $date;
        $this->debitPhoneNumber = $debitPhoneNumber;
        $this->creditPhoneNumber = $creditPhoneNumber;
        $this->fee = $fee;
    }

    public static function fromData(array $data): self
    {
        return new TransactionDetail(
            $data['amount'],
            $data['transactionReference'],
            $data['transactionStatus'],
            $data['createDate'],
            $data['debitParty']['msisdn'],
            $data['creditParty']['msisdn'],
            $data['fee']['feeAmount']
        );
    }
}