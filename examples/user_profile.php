<?php
require __DIR__ . '/../vendor/autoload.php';

$auth = new \Visavi\Auth();

// Получаем массив данных из профиля
$dataProfile = $auth->getProfile();

if (empty($dataProfile)) {
	echo 'Авторизуйтесь для просмотра профиля!';
} else {
	var_dump($dataProfile);
}
