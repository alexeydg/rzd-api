<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config = new Rzd\Config();
$config->setProxy([
    'server' => '94.153.169.60',
    'port'   => '8080',
]);

$config->setUserAgent('Mozilla 4');
$config->setReferer('rzd.ru');


$api = new Rzd\Api($config);

$start = new DateTime();
$date0 = $start->modify('+1 day');

$params = [
    'dir'        => 0,
    'tfl'        => 3,
    'checkSeats' => 0,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => $date0->format('d.m.Y'),
];

echo $api->trainRoutes($params);
