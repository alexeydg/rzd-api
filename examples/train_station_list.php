<?php
require __DIR__ . '/../bootstrap.php';

$api = new \Visavi\Api();

$start = new DateTimeImmutable();
$date0 = $start->modify('+1 day');

$params = [
    'train_num' => '072Е',
    'date'      => $date0->format('d.m.Y'),
];

header('Content-Type: application/json');
echo json_encode($api->trainStationList($params));
