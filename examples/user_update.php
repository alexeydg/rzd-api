<?php
require __DIR__ . '/../bootstrap.php';

$auth = new Rzd\Auth();

// Меняем к примеру отчество
$data = [
    'MIDDLE_NAME'      => 'Владимирович',
    'ACCEPT_POST_FLAG' => 1,
    'GENDER_ID'        => 2,
    'QUESTION_ID'      => 1,
];

if ($auth->setProfile($data)) {
    echo json_encode(['message' => 'Профиль успешно изменен!']);
} else {
    echo json_encode(['message' => 'Ошибка сохранения профиля!']);
}
