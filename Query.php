<?php

class Query {

	public function run($path, $params) {
		$attempts = 0;

		do {

		    $attempts++;
		    $curl = new \Curl\Curl();

		    $session = (!empty($rid)) ? ['rid' => $rid] : [];

		    if (!empty($cookie_data)){
		        foreach ($cookie_data as $key=>$value){
		            $curl->setCookie($key, $value);
		        }
		    }

		    $curl->post($path, $params + $session);

		    $json = json_decode($curl->response, true);

		    if (is_null($json)) {
		        throw new \Exception('Невалидный json');
		    }

		    $result = $json['result'];

		    switch ($result) {
		        case 'RID':
		        	// Вынести в singleton
		        	var_dump('connect');
		            $rid = $json['rid'];
		            $cookie_data = $curl->getResponseCookies();
		            sleep(2);
		            break;
		        case 'OK':
		            $curl->close();
		            return $json;
		            break;
		        default:
		             $curl->close();
		            throw new \Exception('Ошибка: '.$json['message']);
		    }

		} while ($result != 'OK' && $attempts < 5);
	}
}

