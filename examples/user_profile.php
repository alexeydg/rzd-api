<?php
require __DIR__ . '/../bootstrap.php';

$auth = new \Visavi\Auth();

// Получаем массив данных из профиля
$dataProfile = $auth->getProfile();

header('Content-Type: application/json');

if ($dataProfile) {
    echo json_encode($dataProfile);
} else {
    echo json_encode(['error' => 'Необходимо авторизоваться для просмотра профиля!']);
}
