<?php
require __DIR__ . '/../bootstrap.php';

$api = new \Rzd\Api();

$params = [
    'stationNamePart' => 'ЧЕБ',
    'lang'            => 'ru',
    'compactMode'     => 'y',
];

$stations = $api->stationCode($params);

if ($stations) {
    echo json_encode($stations);
} else {
    echo json_encode(['error' => 'Не найдено совпадений!']);
}
