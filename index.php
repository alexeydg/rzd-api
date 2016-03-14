<?php
require __DIR__ . '/vendor/autoload.php';

$api = new Api();

$start = new DateTimeImmutable();
$date0 = $start->modify('+1 day');
$date1 = $start->modify('+5 day');

echo '<h2>Выбор маршрута в одну сторону</h2>';
$params = [
	'dir' => 0,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => $date0->format('d.m.Y'),
];
var_dump($api->trainRoutes($params));

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

echo '<h2>Выбор вагонов</h2>';
$params = [
	'dir' => 0,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => $date0->format('d.m.Y'),
	'time0' => '15:30',
	'tnum0' => '074Е',
];
var_dump($api->trainCarriages($params));

echo '<h2>Просмотр станций</h2>';
$params = [
	'train_num' => '072Е',
	'date' => $date0->format('d.m.Y'),
];
var_dump($api->trainStationList($params));
