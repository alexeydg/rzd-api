<?php
require __DIR__ . '/../bootstrap.php';

$api = new \Visavi\Api();

$start = new DateTimeImmutable();
$date0 = $start->modify('+1 day');

echo '<h2>Выбор вагонов</h2>';

// Получаем акутальный маршрут
$params = [
	'dir' => 0,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => $date0->format('d.m.Y'),
];

$route = $api->trainRoutes($params);

if ($route) {
	$params = [
		'dir' => 0,
		'code0' => '2004000',
		'code1' => '2060600',
		'dt0' => $date0->format('d.m.Y'),
		'time0' => $route[0]['trTime0'],
		'tnum0' => $route[0]['number'],
	];
	var_dump($api->trainCarriages($params));
} else {
	echo 'Не найдено!';
}
