<?php
require __DIR__ . '/vendor/autoload.php';

use \Curl\Curl;

//https://pass.rzd.ru/timetable/public/ru?STRUCTURE_ID=735&layer_id=5371&dir=0&tfl=3&checkSeats=1&code0={{code_from}}&dt0={{date}}&code1={{code_to}}&dt1={{date}}
$i = 0;
$rid = null;
$cookie_file = 'cookie.txt';
$cookie_data = null;
do {

    $i++;
    $curl = new Curl();
    //$curl->setOpt(CURLOPT_FOLLOWLOCATION, true);

    $session = (!empty($rid)) ? ['rid' => $rid] : [];
    var_dump($session, $cookie_data);

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


    if (!empty($cookie_data)){
        foreach ($cookie_data as $key=>$value){
            $curl->setCookie($key, $value);
        }
    }

/*    file_put_contents($cookie_file, $cookie_data);*/
/*
    $curl->setCookieFile($cookie_file);
    $curl->setCookieJar($cookie_file);*/
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
            var_dump($result, $json);
            $curl->close();
            break;
        default:
             $curl->close();
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
