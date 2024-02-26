<?php

declare(strict_types=1);

namespace MobileMoneyMG\MVola;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use MobileMoneyMG\Payment;
use MobileMoneyMG\PaymentStatus;
use Ramsey\Uuid\Uuid;

class MVola implements Payment
{
    private string $apiKey;
    private Client $client;

    private const INITIATE_TRANSACTION_ENDPOINT = '/mvola/mm/transactions/type/merchantpay/1.0.0/';
    private const CHECK_TRANSACTION_STATUS = '/mvola/mm/transactions/type/merchantpay/1.0.0/status/';
    private const userLanguage = 'mg';

    public function __construct(string $apiKey, Client $client)
    {
        $this->apiKey = $apiKey;
        $this->client = $client;
    }
    public function makePayment(string $merchantNumber, string $merchantName, string $phoneNumber, int $amount, string $clientId, string $description = ''): string
    {
        $headers = [
            'Version' => '1.0',
            'X-CorrelationID' => Uuid::uuid4()->toString(),
            'UserLanguage' => self::userLanguage,
            'UserAccountIdentifier' => "msisdn;{$merchantNumber}",
            'partnerName' => $merchantName,
            'Content-Type' => 'application/json',
            'Cache-Control' => 'no-cache',
            'Authorization' => "Bearer {$this->apiKey}"
        ];

        $data = [
            'amount' => (string)($amount),
            'currency' => 'Ar',
            'descriptionText' => $description,
            'requestingOrganisationTransactionReference' => 'sss',
            'requestDate' => (new \DateTimeImmutable())->format('Y-m-d\TH:i:s.v\Z'),
            'originalTransactionReference' => 'sss',
            'debitParty' => [
                [
                    'key' => 'msisdn',
                    'value' => $merchantNumber
                ]
            ],
            'creditParty' => [
                [
                    'key' => 'msisdn',
                    'value' => $phoneNumber
                ]
            ],
            'metadata' => [
                [
                    'key' => 'partnerName',
                    'value' => $this->merchantName
                ]
            ],
        ];

        $response = $this->client->request('POST', self::INITIATE_TRANSACTION_ENDPOINT, [
            'headers' => $headers,
            'json' => $data
        ]);
        $jsonResponse = json_decode($response->getBody()->getContents(), true);

        return $jsonResponse['serverCorrelationId'];
    }

    public function checkStatus(string $id): PaymentStatus
    {
        $headers = [
            'Version' => '1.0',
            'X-CorrelationID' => $id,
            'UserLanguage' => self::userLanguage,
            'UserAccountIdentifier' => "msisdn;{$this->merchantNumber}",
            'partnerName' => $this->merchantName,
            'Cache-Control' => 'no-cache',
            'Authorization' => "Bearer {$this->apiKey}"
        ];

        $uri = self::CHECK_TRANSACTION_STATUS . $id;
        $response = $this->client->request('GET', $uri, [
            'headers' => $headers
        ]);

        $status = json_decode($response->getBody()->getContents(), true)['status'];
        return PaymentStatus::from($status);
    }

    public function getTransactionRequest(string $id): string
    {
        // TODO: Implement getTransactionRequest() method.
        return 'test';
    }
}