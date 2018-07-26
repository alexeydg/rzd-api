<?php
require dirname(__DIR__) . '/vendor/autoload.php';

$config = new Rzd\Config();
$config->setAuth('username', 'password');

$auth = new Rzd\Auth($config);

if ($auth->login()) {
    echo json_encode([
        'success' => true,
        'message' => 'Пользователь успешно авторизован!'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Не удалось авторизоваться на сайте!'
    ]);

}

