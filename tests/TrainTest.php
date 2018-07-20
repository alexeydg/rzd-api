<?php

use PHPUnit\Framework\TestCase;
use Rzd\Api;

class TrainTest extends TestCase
{
    private $api;

    protected function setUp()
    {
        $this->api = new Api();

        $start = new DateTime();
        $this->date0 = $start->modify('+1 day');
        $this->date1 = $start->modify('+5 day');
    }

    /**
     * Тест получения маршрутов
     */
    public function testTrainRoutes()
    {
        $params = [
            'dir'        => 0,
            'tfl'        => 3,
            'checkSeats' => 1,
            'code0'      => '2004000',
            'code1'      => '2000000',
            'dt0'        => $this->date0->format('d.m.Y'),
        ];

        $trainRoutes = $this->api->trainRoutes($params);
        $this->assertTrue(is_array($trainRoutes));
    }

    /**
     * Тест получения маршрутов туда-обратно
     */
    public function testTrainRoutesReturn()
    {
        $params = [
            'dir'        => 1,
            'tfl'        => 3,
            'checkSeats' => 1,
            'code0'      => '2004000',
            'code1'      => '2000000',
            'dt0'        => $this->date0->format('d.m.Y'),
            'dt1'        => $this->date1->format('d.m.Y'),
        ];

        $trainRoutesReturn =  $this->api->trainRoutesReturn($params);
        $this->assertTrue(is_array($trainRoutesReturn));
    }

    /**
     * Тест получения вагонов
     */
    public function testTrainCarriages()
    {
        $params = [
            'dir'        => 0,
            'tfl'        => 3,
            'checkSeats' => 1,
            'code0'      => '2004000',
            'code1'      => '2000000',
            'dt0'        => $this->date0->format('d.m.Y'),
        ];

        $route = $this->api->trainRoutes($params);

        if ($route) {
            $params = [
                'dir'   => 0,
                'code0' => '2004000',
                'code1' => '2000000',
                'dt0'   => $this->date0->format('d.m.Y'),
                'time0' => $route[0]['trTime0'],
                'tnum0' => $route[0]['number'],
            ];

            $trainCarriages = $this->api->trainCarriages($params);
            $this->assertTrue(is_array($trainCarriages));
        }
    }

    /**
     * Тест просмотра станций
     */
    public function testTrainStationList()
    {
        $params = [
            'train_num' => '072Е',
            'date'      => $this->date0->format('d.m.Y'),
        ];

        $trainStationList = $this->api->trainStationList($params);
        $this->assertTrue(is_array($trainStationList));
    }

    /**
     * Тест кодов станций
     */
    public function testStationCode()
    {
        $params = [
            'stationNamePart' => 'ЧЕБ',
            'lang'            => 'ru',
            'compactMode'     => 'y',
        ];

        $stationCode = $this->api->stationCode($params);
        $this->assertTrue(is_array($stationCode));
    }
}
