<?php
require __DIR__ . '/../bootstrap.php';

$auth = new \Visavi\Auth();

$dataProfile = $auth->getProfile();

if (empty($dataProfile)) {
	echo 'Авторизуйтесь для изменения профиля!';
} else {
	// Меняем к примеру отчество
	$replaceData = ['MIDDLE_NAME' => 'Васильевич', 'ACCEPT_POST_FLAG' => 1, 'GENDER_ID' => 2, 'QUESTION_ID' => 1];

	var_dump($auth->setProfile(array_merge($dataProfile, $replaceData)) ? 'Профиль успешно изменен!' : 'Ошибка сохранения профиля!');
}
