<?php

class Api {

	protected $path = 'https://pass.rzd.ru/timetable/public/ru';

	public function __construct() {
		$this->query = new Query;
	}

	/**
	 * Получение числа свободных мест в 1 точку
	 * @param  array $params массив параметров
	 * @return array         список мест
	 */
	public function freeSeats(array $params) {

		// TODO: Сделать более структурный вывод в виде таблиц
		$seats = $this->query->run($this->path, $params);
		return $seats['tp'][0]['list'];
	}


	/**
	 * Получение числа свободных мест туда-обратно
	 * @param  array $params массив параметров
	 * @return array         список мест
	 */
	public function freeSeatsReturn(array $params) {

		// TODO: Сделать более структурный вывод в виде таблиц
		$seats = $this->query->run($this->path, $params);
		return [$seats['tp'][0]['list'], $seats['tp'][1]['list']];
	}
}

