<?php

class Auth {

	protected $loginPath = 'https://pass.rzd.ru/timetable/j_security_check/ru';

	protected $profilePath = 'https://pass.rzd.ru/selfcare/editProfile/ru';

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

		$query = $this->query->send($this->loginPath, $params);

		$cookies = $query->getResponseCookies();

		return !empty($cookies['AuthFlag']) ? true : false;
	}

	/**
	 * Метод чтения страниц
	 * @param  string $path адрес страницы
	 * @return string       html-код страницы
	 */
	public function getPage($path)
	{
		$query = $this->query->send($path);

		return $query->response;
	}

	/**
	 * Получение данных пользователя
	 * @return array массив данных пользователя
	 */
	public function getProfile()
	{
		$profile = $this->getPage($this->profilePath);

		$saw = new nokogiri($profile);

		return $saw->get('table.profileTable input')->toArray();
	}
}
