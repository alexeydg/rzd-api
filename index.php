<?php
require __DIR__ . '/vendor/autoload.php';

$api = new Api();

// Выбор маршрута в одну сторону
$params = [
	'dir' => 0,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => '13.03.2016',
];


//var_dump($api->trainRoutes($params));


// Выбор маршрута туда-обратно
$params = [
	'dir' => 1,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => '27.03.2016',
	'dt1' => '30.03.2016',
];
//var_dump($api->trainRoutesReturn($params));


// Выбор вагонов
$params = [
	'dir' => 0,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => '13.03.2016',
	'time0' => '15:30',
	'tnum0' => '074Е',
];

//var_dump($api->trainCarriages($params));



// Выбор вагонов
$params = [
	'train_num' => '072Е',
	'date' => '13.03.2016',
];

//var_dump($api->trainStationList($params));
