<?php
require __DIR__ . '/../vendor/autoload.php';

$auth = new \Visavi\Auth();

$username = '';
$password = '';

// Проверка авторизации
if (empty($username) || empty($password)) {
	echo 'Установите логин и пароль в файле examples/user_login.php';
} else {
	var_dump($auth->login($username, $password) ? 'Пользователь '.$username.' успешно авторизован!' : 'Не удалось авторизоваться!');
}
