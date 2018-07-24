<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$api = new Rzd\Api();

$params = [
    'stationNamePart' => 'ЧЕБ',
    'lang'            => 'ru',
    'compactMode'     => 'y',
];

$stations = $api->stationCode($params);

if ($stations) {
    echo $stations;
} else {
    echo json_encode(['error' => 'Не найдено совпадений!']);
}
