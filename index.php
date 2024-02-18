<?php

use Dotenv\Dotenv;

require 'vendor/autoload.php';

$env = parse_ini_file('.env');
$api = $env['MVOLA_API_KEY'];


$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$mvola = \MobileMoneyMG\MobileMoneyFactory::createMVola();
$transactionId = $mvola->makePayment('0343500003', 1000, 'joely', 'test');
$status = $mvola->checkStatus($transactionId);
echo $status->name;