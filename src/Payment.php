<?php

namespace MobileMoneyMG;

interface Payment
{
    public function makePayment(string $phoneNumber, int $amount, string $clientId, string $description = ''): string;

    public function checkStatus(string $id): PaymentStatus;

    public function getTransactionRequest(string $id): string;
}