<?php
require __DIR__ . '/vendor/autoload.php';

$auth = new Auth();

$username = '';
$password = '';

// Проверка авторизации
echo $auth->login($username, $password) ? 'Пользователь '.$username.' авторизован' : 'Не удалось авторизоваться';


// Получаем массив данных из профиля
$profile = $auth->getProfile();

var_dump($profile);
