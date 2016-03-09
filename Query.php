<?php

class Rzd2 {

	private $urlData = 'https://pass.rzd.ru/timetable/public/ru?STRUCTURE_ID=735&layer_id=5371&dir=0&tfl=3&checkSeats=1&code0={{code_from}}&dt0={{date}}&code1={{code_to}}&dt1={{date}}';
	private $data;
	private $replace = [
		'{{code_from}}',
		'{{code_to}}',
		'{{date}}',
	];
	private $secure = '&rid={{rid}}';
	private $replaceSecure = [
		'{{rid}}',
		'{{session_id}}',
	];
	private $cookie = 'cookie.txt';

	public function request($data) {
		$this->data = $data;
		$this->urlData = str_replace($this->replace, $this->data, $this->urlData);
		$ch = curl_init($this->urlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		$result = json_decode(curl_exec($ch), true);
		$this->urlData .= str_replace($this->replaceSecure, [$result['rid']], $this->secure);
		sleep(2);
		$ch = curl_init($this->urlData);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cookie);
		$result = json_decode(curl_exec($ch), true);


		$result = reset($result['tp']);
		$result = $result['list'];

		foreach ($result as $train) {
			if (isset($train['cars']) && is_array($train['cars']))
				foreach ($train['cars'] as $ticket) {

					echo $resultExec = 'На '.$data[2].' - '.$train['number']." - ".$ticket['type'].' за '.$ticket['tariff'].' - '.$ticket['freeSeats'].' м<br>';


				}
		}
	}
}

