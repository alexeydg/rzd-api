<?php
require __DIR__ . '/../vendor/autoload.php';

$api = new \Visavi\Api();

$start = new DateTimeImmutable();
$date0 = $start->modify('+1 day');
$date1 = $start->modify('+5 day');

echo '<h2>Выбор маршрута туда-обратно</h2>';
$params = [
	'dir' => 1,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => $date0->format('d.m.Y'),
	'dt1' => $date1->format('d.m.Y'),
];
var_dump($api->trainRoutesReturn($params));
