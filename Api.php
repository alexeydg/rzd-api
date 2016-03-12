<?php

class Api {

	protected $path = 'https://pass.rzd.ru/timetable/public/ru';

	public function __construct() {
		$this->query = new Query;
	}

	/**
	 * Получение числа свободных мест
	 * @param  array $params массив параметров
	 * @return array         список мест
	 */
	public function freeSeats(array $params) {

		return $this->query->run($this->path, $params);
	}

	/**
	 * Получение числа мест
	 * @param  array $params массив параметров
	 * @return array         список мест
	 */
	public function freeSeats(array $params) {

		return $this->query->run($this->path, $params);
	}
}

