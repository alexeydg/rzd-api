<?php

class Query {

	/**
	 * Запрос на получение данных
	 * @param  string $path   путь к странице
	 * @param  array $params  массив параметров
	 * @return array          массив данных
	 */
	public function run($path, $params) {

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
					$session = $json['rid'];
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
}
