<?php

class Query {

	/**
	 * Запрос на получение данных
	 * @param  string $path   путь к странице
	 * @param  array $params  массив параметров
	 * @return array          массив данных
	 */
	public function run($path, $params)
	{
		do {
			$curl = new \Curl\Curl();

			if (!empty($cookies) && !empty($session)){
				foreach ($cookies as $key=>$value){
					$curl->setCookie($key, $value);
				}

				$params += ['rid' => $session];
			}

			$curl->post($path, $params);

			$json = json_decode($curl->response, true);

			if (is_null($json)) throw new \Exception('Ошибка: Невалидный json');

			switch ($json['result']) {
				case 'RID':
					$session = $this->getRid($json);
					$cookies = $curl->getResponseCookies();
					sleep(1);
					break;
				case 'OK':
					$curl->close();
					return $json;
					break;
				default:
					$curl->close();
					throw new \Exception('Ошибка: '.$json['message']);
			}

		} while (true);
	}

	/**
	 * Получение уникального ключа RID
	 * @param  string $json данные
	 * @return string       уникальный ключ
	 */
	protected function getRid($json)
	{
		foreach (['rid', 'RID'] as $rid){
			if (isset($json[$rid])) {
				return $json[$rid];
			}
		}

		throw new \Exception('Ошибка: Не найден уникальный ключ');
	}
}
