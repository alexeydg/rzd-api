<?php
require __DIR__ . '/../bootstrap.php';

$auth = new \Visavi\Auth();

header('Content-Type: application/json');

// Проверка авторизации
if (empty(USERNAME) || empty(PASSWORD)) {

    echo json_encode(['success' => false, 'message' => 'Установите логин и пароль в файле bootstrap.php']);

} else {

    if ($auth->login(USERNAME, PASSWORD)) {
        echo json_encode(['success' => true, 'message' => 'Пользователь '.USERNAME.' успешно авторизован!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Установите логин и пароль в файле bootstrap.php']);

    }
}
