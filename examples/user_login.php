<?php
require __DIR__ . '/../bootstrap.php';

$auth = new \Visavi\Auth();

// Проверка авторизации
if (empty(USERNAME) || empty(PASSWORD)) {
	echo 'Установите логин и пароль в файле bootstrap.php';
} else {
	var_dump($auth->login(USERNAME, PASSWORD) ? 'Пользователь '.USERNAME.' успешно авторизован!' : 'Не удалось авторизоваться!');
}
