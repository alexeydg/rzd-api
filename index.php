<?php
require __DIR__ . '/vendor/autoload.php';

$api = new Api();

// В одну сторону
$params = [
	'STRUCTURE_ID' => 735,
	'layer_id' => 5371,
	'dir' => 0,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => '27.03.2016',
];


var_dump($api->freeSeats($params));


// туда-обратно
$params = [
	'STRUCTURE_ID' => 735,
	'layer_id' => 5371,
	'dir' => 1,
	'tfl' => 3,
	'checkSeats' => 1,
	'code0' => '2004000',
	'code1' => '2060600',
	'dt0' => '27.03.2016',
	'dt1' => '30.03.2016',
];
var_dump($api->freeSeatsReturn($params));

exit;

















//https://pass.rzd.ru/timetable/public/ru?STRUCTURE_ID=735&layer_id=5371&dir=0&tfl=3&checkSeats=1&code0={{code_from}}&dt0={{date}}&code1={{code_to}}&dt1={{date}}
$attempts = 0;

do {

	$attempts++;
	$curl = new Curl();

	$session = (!empty($rid)) ? ['rid' => $rid] : [];

	if (!empty($cookie_data)){
		foreach ($cookie_data as $key=>$value){
			$curl->setCookie($key, $value);
		}
	}

	$curl->post('https://pass.rzd.ru/timetable/public/ru', array(
		'STRUCTURE_ID' => 735,
		'layer_id' => 5371,
		'dir' => 0,
		'tfl' => 3,
		'checkSeats' => 1,
		'code0' => '2004000',
		'code1' => '2060600',
		'dt0' => '27.03.2016',
	) + $session);

	$json = json_decode($curl->response, true);

	if (is_null($json)) {
		throw new \Exception('Невалидный json');
	}

	$result = $json['result'];

	switch ($result) {
		case 'RID':
			$rid = $json['rid'];
			$cookie_data = $curl->getResponseCookies();
			sleep(2);
			break;
		case 'OK':
			var_dump($json);
			$curl->close();
			break;
		default:
			 $curl->close();
			throw new \Exception('Ошибка: '.$json['message']);
	}

} while ($result != 'OK' && $attempts < 5);

exit;

require_once ('Rzd2.php');

$rzd = new Rzd2();
$rzd->request([
	'2004000', // Петербург
	'2060600', // Киров
	'27.03.2016',
]);

exit;


// TODO: Избавиться от муторных вводов кодов назначений
$rzd = new Rzd();
$rzd->request([
	'Москва',
	'2000000',
	'Санкт-Петербург',
	'2004000',
	'28.03.2016',
]);

exit;

$rzd = new Rzd();
$rzd->request([
	'Санкт-Петербург',
	'2004000',
	'Киров',
	'2060600',
	'27.03.2016',
]);


$rzd = new Rzd();
$rzd->request([
	'Санкт-Петербург',
	'2004000',
	'Киров',
	'2060600',
	'28.03.2016',
]);
