<?php

declare(strict_types=1);

namespace MobileMoneyMG;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use MobileMoneyMG\MVola\MVola;

abstract class MobileMoneyFactory
{
    public static function createMVola(): MVola
    {
        $key = $_ENV['MVOLA_API_KEY'];
        $baseUri = $_ENV['ENV'] === 'PROD' ? 'https://api.mvola.mg' : 'https://devapi.mvola.mg';
        $merchantNumber = $_ENV['MERCHANT_NUMBER'];
        $merchantName = $_ENV['MERCHANT_NAME'];
        $client = new Client(['base_uri' => $baseUri]);
        return new MVola($key, $client, $merchantNumber, $merchantName);
    }
}