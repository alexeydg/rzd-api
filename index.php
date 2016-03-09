<?php
require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;

//https://pass.rzd.ru/timetable/public/ru?STRUCTURE_ID=735&layer_id=5371&dir=0&tfl=3&checkSeats=1&code0={{code_from}}&dt0={{date}}&code1={{code_to}}&dt1={{date}}
$i = 0;
$rid = null;

do {

    $i++;
    $curl = new Curl();
    //$curl->setOpt(CURLOPT_FOLLOWLOCATION, true);

    $session = (!empty($rid)) ? ['rid' => $rid] : [];
    var_dump($session);

    $curl->post('https://pass.rzd.ru/timetable/public/ru', array(
        'STRUCTURE_ID' => 735,
        'layer_id' => 5371,
        'dir' => 0,
        'tfl' => 3,
        'checkSeats' => 1,
        'code0' => '2000000',
        'code1' => '2004000',
        'dt0' => '28.03.2016',
    ) + $session);


    $json = json_decode($curl->response, true);

    if (is_null($json)) {
        throw new \Exception('Не валидный json');
    }

    $result = $json['result'];


    switch ($result) {
        case 'RID':
            $rid = $json['rid'];
            sleep(2);
            break;
        case 'OK':
            var_dump($json);
            break;
        default:
            throw new \Exception('Ошибка: '.$json['message']);
    }
    # code...
} while ($result != 'OK' && $i < 5);

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
