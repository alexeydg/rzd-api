<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$auth = new Rzd\Auth();

// Получаем массив данных из профиля
$profile = $auth->getProfile();

if ($profile) {
    echo $profile;
} else {
    echo json_encode(['error' => 'Необходимо авторизоваться для просмотра профиля!']);
}
