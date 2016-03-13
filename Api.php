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
	public function trainRoutes(array $params)
	{
		$layer = [
			'STRUCTURE_ID' => 735,
			'layer_id' => 5371,
		];

		// TODO: Сделать более структурный вывод в виде таблиц
		$routes = $this->query->run($this->path, $layer + $params);
		return $routes['tp'][0]['list'];
	}


	/**
	 * Получение числа свободных мест туда-обратно
	 * @param  array $params массив параметров
	 * @return array         список мест
	 */
	public function trainRoutesReturn(array $params)
	{
		$layer = [
			'STRUCTURE_ID' => 735,
			'layer_id' => 5371,
		];

		// TODO: Сделать более структурный вывод в виде таблиц
		$routes = $this->query->run($this->path, $layer + $params);
		return [$routes['tp'][0]['list'], $routes['tp'][1]['list']];
	}

	/**
	 * Получение списка вагонов
	 * @param  array $params массив параметров
	 * @return array         список мест
	 */
	public function trainCarriages(array $params)
	{
		$layer = [
			'STRUCTURE_ID' => 735,
			'layer_id' => 5373,
		];

		// TODO: Сделать более структурный вывод в виде таблиц
		$routes = $this->query->run($this->path, $layer + $params);
		return ['cars' => $routes['lst'][0]['cars'], 'schemes' => $routes['schemes'], 'companies' => $routes['insuranceCompany']];
	}

	/**
	 * Получение списка станций
	 * @param  array  $params массив параметров
	 * @return array          список станций
	 */
	public function trainStationList(array $params)
	{
		$this->path = str_replace('https://', 'http://', $this->path); // Fix

		$layer = [
			'STRUCTURE_ID' => 735,
			'layer_id' => 5451,
		];

		// TODO: Сделать более структурный вывод в виде таблиц
		$routes = $this->query->run($this->path, $layer + $params);
		return ['train' => $routes['Train'], 'routes' => $routes['Routes']];
	}
}

