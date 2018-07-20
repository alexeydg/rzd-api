<?php
require __DIR__ . '/../bootstrap.php';

$auth = new \Rzd\Auth();

// Проверка авторизации
if (empty(USERNAME) || empty(PASSWORD)) {

    echo json_encode([
        'success' => false,
        'message' => 'Для авторизации необходим логин и пароль пользователя!'
    ]);

} else {

    if ($auth->login(USERNAME, PASSWORD)) {
        echo json_encode([
            'success' => true,
            'message' => 'Пользователь '.USERNAME.' успешно авторизован!'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Не удалось авторизоваться на сайте!'
        ]);

    }
}
