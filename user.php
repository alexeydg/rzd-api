<?php
require __DIR__ . '/vendor/autoload.php';

$auth = new Auth();

$username = '';
$password = '';

// Проверка авторизации
var_dump($auth->login($username, $password) ? 'Пользователь '.$username.' авторизован' : 'Не удалось авторизоваться');

// Получаем массив данных из профиля
$dataProfile = $auth->getProfile();

// Меняем к примеру отчество
$replaceData = ['MIDDLE_NAME'=> 'Васильевич', 'ACCEPT_POST_FLAG' => 1, 'GENDER_ID' =>2, 'QUESTION_ID' => 1];

var_dump($auth->setProfile(array_merge($dataProfile, $replaceData)) ? 'Профиль сохранен' : 'Ошибка сохранения профиля');
