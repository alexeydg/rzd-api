<?php

class Rzd {
	private $urlMain = 'https://pass.rzd.ru/timetable/public/ru?';
	private $urlData = 'STRUCTURE_ID=735&layer_id=5371&dir=0&tfl=3&checkSeats=1&st0={{from}}&code0={{code_from}}&dt0={{date}}&st1={{to}}&code1={{code_to}}&dt1={{date}}';
	private $data;
	private $replace = [
		'{{from}}',
		'{{code_from}}',
		'{{to}}',
		'{{code_to}}',
		'{{date}}',
	];
	private $secure = '&rid={{rid}}';
	private $replaceSecure = ['{{rid}}'];
	private $cookie = 'cookie.txt';

	private function UrlEncode($string) {
	  $entities = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
	  $replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
	  return str_replace($entities, $replacements, urlencode($string));
	}

	public function request($data) {
		$this->data = $data;
		$this->urlData = str_replace($this->replace, $this->data, $this->urlData);

		$this->UrlEncode($this->urlData);
		$ch = curl_init($this->urlMain . $this->UrlEncode($this->urlData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		$result = json_decode(curl_exec($ch), true);

		sleep(5);
		$this->urlData .= str_replace($this->replaceSecure, [$result['rid']], $this->secure);
		$ch = curl_init($this->urlMain . $this->UrlEncode($this->urlData));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		$result = json_decode(curl_exec($ch), true);
		curl_close($ch);
		unset($ch);

		file_put_contents($this->cookie, '');

		$result = $result['tp'][0]['list'];
		$tr_number = "";
		$resultExec = '';

		foreach ($result as $train) {

			if (isset($train['cars']) && is_array($train['cars'])) {
				foreach ($train['cars'] as $ticket) {
					# здесь можно написать условие, например если цена меньше 4000р то делаем все что ниже и высылаем смс
					if ($ticket['type'] === 'Плац' && $tr_number != $train['number']) {
					  $resultExec .= 'На '.$data[4]. ' ' .$train['time0'] . '-' . $train['time1'] . ' -- '.$train['number']." - ".$ticket['type'].' за '.$ticket['tariff'].'р. - '.$ticket['freeSeats'].' м' ."\n";
					  $tr_number = $train['number'];
					  $reqSeats = "STRUCTURE_ID=735&layer_id=5373&dir=0&st0={{from}}&st1={{to}}&code0={{code_from}}&code1={{code_to}}&dt0={{date}}&time0={{time0}}&tnum={{tnum}}&dis={{dis}}&trDate0={{trDate0}}&route0={{route0}}&route1={{route1}}&bEntire={{bEntire}}&brand={{brand}}&carrier={{carrier}}&tnum0={{tnum0}}";
					  $replaceSeat = [
						'{{time0}}',
						'{{tnum}}',
						'{{dis}}',
						'{{trDate0}}',
						'{{route0}}',
						'{{route1}}',
						'{{bEntire}}',
						'{{brand}}',
						'{{carrier}}',
						'{{tnum0}}'
					  ];
					  $dataSeat = [
						$train['time0'],
						$train['number'],
						isset($train['dis']) ? $train['dis'] : '',
						$train['trDate0'],
						$train['route0'],
						$train['route1'],
						$train['bEntire'],
						isset($train['brand']) ? $train['brand'] : '',
						$train['carrier'],
						$train['number']
					  ];
					  $reqSeats = str_replace($replaceSeat, $dataSeat, $reqSeats);
					  $reqSeats = str_replace($this->replace, $this->data, $reqSeats);

					  $ch = curl_init($this->urlMain . $this->UrlEncode($reqSeats));
					  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					  curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
					  curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
					  $result = json_decode(curl_exec($ch), true);
					  sleep(4);
					  $reqSeats .= str_replace($this->replaceSecure, [$result['RID']], $this->secure);

					  $ch = curl_init($this->urlMain . $this->UrlEncode($reqSeats));
					  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					  curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
					  curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
					  $result = json_decode(curl_exec($ch), true);
					  $result = $result['lst'][0]['cars'];
					  foreach ($result as $car) {
						  $resultExec .= '<br><br><strong>Вагон ' . $car['cnumber'] . '</strong> ' . $car['carrier'] . "<br>" . $car['typeLoc'] . '(' . $car['clsType'] . ')' . "<br>Цена: " . $car['tariff'] . "<br>Места: " . $car['places'] . "";
						  foreach ($car['seats'] as $seats) {
								$resultExec .= '<br>'.str_replace('&nbsp;', ' ', $seats['label']) . ': ' . $seats['free'];
						  }
					  }
					  curl_close($ch);
					  unset($ch);
					  file_put_contents($this->cookie, '');
					}
				}
			}
		}
		echo $resultExec;
	}
}


/*class Rzd {

	private $urlData = 'https://pass.rzd.ru/timetable/public/ru?STRUCTURE_ID=735&layer_id=5371&dir=0&tfl=3&checkSeats=1&st0={{from}}&code0={{code_from}}&dt0={{date}}&st1={{to}}&code1={{code_to}}&dt1={{date}}';
	private $data;
	private $replace = [
		'{{from}}',
		'{{code_from}}',
		'{{to}}',
		'{{code_to}}',
		'{{date}}',
	];
	private $secure = '&rid={{rid}}&JSESSIONID={{session_id}}';
	private $replaceSecure = [
		'{{rid}}',
		'{{session_id}}',
	];
	private $cookie = 'cookie';

	public function request($data) {
		$this->data = $data;
		$this->urlData = str_replace($this->replace, $this->data, $this->urlData);
		$ch = curl_init($this->urlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		$result = json_decode(curl_exec($ch), true);
		var_dump($result); exit;
		$this->urlData .= str_replace($this->replaceSecure, [$result['rid'], $result['SESSION_ID']], $this->secure);
		sleep(2);
		$ch = curl_init($this->urlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		$result = json_decode(curl_exec($ch), true);

		var_dump($result);  exit;
		$result = reset($result['tp']);
		$result = $result['list'];
		foreach ($result as $train) {
			if (isset($train['cars']) && is_array($train['cars']))
				foreach ($train['cars'] as $ticket) {
					# здесь можно написать условие, например если цена меньше 4000р то делаем все что ниже и высылаем смс
					$resultExec = 'На '.$data[4].' - '.$train['number']." - ".$ticket['type'].' за '.$ticket['tariff'].' - '.$ticket['freeSeats'].' м';
					$ch = curl_init("sms.ru/sms/send");
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);
					curl_setopt($ch, CURLOPT_POSTFIELDS, array(
						"api_id" => 'id sms.ru',
						"to"      => 'ваш телефон',
						"text"   => $resultExec,
					));
					sleep(2);
					$body = curl_exec($ch);
					curl_close($ch);
				}
		}
	}
}*/

