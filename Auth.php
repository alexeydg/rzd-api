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

		return isset($cookies['AuthFlag']) && $cookies['AuthFlag'] != 'false' ? true : false;
	}

	/**
	 * Метод чтения страниц
	 * @param  string $path адрес страницы
	 * @return string       html-код страницы
	 */
	public function page($path, array $params = [])
	{
		$query = $this->query->send($path, $params);

		return $query->response;
	}

	/**
	 * Получение данных пользователя
	 * @return array массив данных пользователя
	 */
	public function getProfile()
	{
		$profile = $this->page($this->profilePath);

		$saw = new nokogiri($profile);

		// Здесь чуть не доработано, селекты нужно отдельно парсить
		$dataProfile = $saw->get('form.selfcareForm input')->toArray();

		$profile = [];

		// Игнорируем ненужные поля
		$ignoreName = ['userpassword', 'userpassword_CONFIRM', 'DATA'];

		foreach($dataProfile as $data) {

			if (empty($data['name']) || in_array($data['name'], $ignoreName)) continue;

			$profile[$data['name']] = isset($data['value']) ? $data['value'] : '';
		}

		return $profile;
	}

	/**
	 * Сохранение
	 * @param  array $data данные профиля
	 * @return boolean     результат сохраниения
	 */
	public function setProfile($data)
	{
		$profile = $this->page($this->profilePath, $data);

		$saw = new nokogiri($profile);

		$result = $saw->get('.warningBlock')->toText();

		return $result == 'Профиль пользователя успешно изменен' ? true : false;
	}
}
