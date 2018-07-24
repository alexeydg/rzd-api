<?php

namespace Rzd;

use Exception;

class Api
{
    protected $path = 'https://pass.rzd.ru/timetable/public/ru';

    protected $suggestionPath = 'http://pass.rzd.ru/suggester';

    private $query;

    public function __construct(Config $config = null)
    {
        if (! $config) {
            $config = new Config();
        }

        $this->query = new Query($config);
    }

    /**
     * Получение числа свободных мест в 1 точку
     *
     * @param  array $params массив параметров
     * @return string        список мест
     * @throws Exception
     */
    public function trainRoutes(array $params): string
    {
        $layer = [
            'STRUCTURE_ID' => 735,
            'layer_id'     => 5371,
        ];

        $routes = json_decode($this->query->send($this->path, $layer + $params));

        return json_encode($routes->tp[0]->list);
    }

    /**
     * Получение числа свободных мест туда-обратно
     *
     * @param  array $params массив параметров
     * @return string         список мест
     * @throws Exception
     */
    public function trainRoutesReturn(array $params): string
    {
        $layer = [
            'STRUCTURE_ID' => 735,
            'layer_id'     => 5371,
        ];

        $routes = json_decode($this->query->send($this->path, $layer + $params));

        return json_encode([$routes->tp[0]->list, $routes->tp[1]->list]);
    }

    /**
     * Получение списка вагонов
     *
     * @param  array $params массив параметров
     * @return string        список мест
     * @throws Exception
     */
    public function trainCarriages(array $params): string
    {
        $layer = [
            'STRUCTURE_ID' => 735,
            'layer_id'     => 5373,
        ];

        $routes = json_decode($this->query->send($this->path, $layer + $params));

        return json_encode([
            'cars'      => $routes->lst[0]->cars,
            'schemes'   => $routes->schemes,
            'companies' => $routes->insuranceCompany,
        ]);
    }

    /**
     * Получение списка станций
     *
     * @param  array $params массив параметров
     * @return string        список станций
     * @throws Exception
     */
    public function trainStationList(array $params): string
    {
        $layer = [
            'layer_id' => 5804,
        ];

        $routes = json_decode($this->query->send($this->path, $layer + $params));

        return json_encode([
            'train' => $routes->Train,
            'routes' => $routes->Routes,
        ]);
    }

    /**
     * Получение списка кодов станций
     *
     * @param  array $params массив параметров
     * @return string        список соответствий
     * @throws Exception
     */
    public function stationCode(array $params): string
    {
        $routes = json_decode($this->query->send($this->suggestionPath, $params, 'get'));


        var_dump($routes); exit;

       /* $stations = [];

        if ($routes->response && is_array($routes->response)) {
            foreach ($routes->response as $station){
                if (mb_stristr($station->n, $params['stationNamePart'])) {
                    $stations[] = ['station' => $station->n,  'code' => $station->c];
                }
            }
        }

        return $stations;*/
    }
}
