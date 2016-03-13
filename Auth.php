<?php

class Auth {

	protected $path = 'https://rzd.ru/timetable/j_security_check/ru';

	public function __construct() {
		$this->query = new Query;
	}

	/**
	 * Авторизация на сайте pass.rzd.ru
	 * @param  string $username логин пользователя
	 * @param  string $password пароль пользователя
	 * @return boolean          результат авторизации
	 */
	public function login($username, $password)
	{
		$params = [
			'j_username' => $username,
			'j_password' => $password,
		];


		$result = $this->query->get($this->path, $params);
		return $result;
	}
}
