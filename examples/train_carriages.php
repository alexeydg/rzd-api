<?php
require __DIR__ . '/../bootstrap.php';

$api = new \Rzd\Api();

$start = new DateTime();
$date0 = $start->modify('+1 day');

// Получаем акутальный маршрут
$params = [
    'dir'        => 0,
    'tfl'        => 3,
    'checkSeats' => 1,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => $date0->format('d.m.Y'),
];
$route = $api->trainRoutes($params);

if ($route) {
    $params = [
        'dir'   => 0,
        'code0' => '2004000',
        'code1' => '2000000',
        'dt0'   => $date0->format('d.m.Y'),
        'time0' => $route[0]['trTime0'],
        'tnum0' => $route[0]['number'],
    ];

    echo json_encode($api->trainCarriages($params));

} else {
    echo json_encode(['error' => 'Не удалось найти маршрут']);
}
