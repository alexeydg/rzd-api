<?php
require __DIR__ . '/../vendor/autoload.php';

$api = new \Visavi\Api();

$start = new DateTimeImmutable();
$date0 = $start->modify('+1 day');

echo '<h2>Просмотр станций</h2>';
$params = [
	'train_num' => '072Е',
	'date' => $date0->format('d.m.Y'),
];
var_dump($api->trainStationList($params));
