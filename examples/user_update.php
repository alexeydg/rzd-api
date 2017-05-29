<?php
require __DIR__ . '/../bootstrap.php';

$auth = new \Visavi\Auth();

$dataProfile = $auth->getProfile();

header('Content-Type: application/json');

if ($dataProfile) {
    // Меняем к примеру отчество
    $replaceData = ['MIDDLE_NAME' => 'Владимирович', 'ACCEPT_POST_FLAG' => 1, 'GENDER_ID' => 2, 'QUESTION_ID' => 1];

    if ($auth->setProfile(array_merge($dataProfile, $replaceData))) {
        echo json_encode(['message' => 'Профиль успешно изменен!']);
    } else {
        echo json_encode(['message' => 'Ошибка сохранения профиля!']);
    }

} else {
    echo json_encode(['error' => 'Необходимо авторизоваться для просмотра профиля!']);
}
