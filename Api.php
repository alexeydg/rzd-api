<?php

class Api {

	public $path = 'https://pass.rzd.ru/timetable/public/ru';

	public function __construct() {
		$this->query = new Query;
	}

	public function mesta($params) {

		return $this->query->run($this->path, $params);

	}
}

