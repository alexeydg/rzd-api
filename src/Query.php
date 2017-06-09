<?php
namespace Visavi;

class Query {

    /**
     * Запрос на получение данных
     *
     * @param  string $path  путь к странице
     * @param  array $params массив параметров
     * @return array         массив данных
     * @throws \Exception
     */
    public function run($path, array $params)
    {
        $curl = new \Curl\Curl();

        do {
            if (!empty($cookies) && !empty($session)){
                foreach ($cookies as $key=>$value){
                    $curl->setCookie($key, $value);
                }

                $params += ['rid' => $session];
            }

            $curl->post($path, $params);

            if ($this->isJson($curl->response)) {
                $response = json_decode($curl->response, true);
                $result = $response['result'];
            } else {
                $response = (array)$curl->response;
                $result = (isset($response['type']) && $response['type'] == 'REQUEST_ID') ? 'RID' : 'OK';
            }

            if (is_null($response)) {
                throw new \Exception('Ошибка: Не удалось получить данные');
            }

            switch ($result) {
                case 'RID':
                    $session = $this->getRid($response);
                    $cookies = $curl->responseCookies;
                    sleep(1);
                    break;
                case 'OK':
                    $curl->close();
                    if (isset($response['tp'][0]['msgList'][0])) {
                        throw new \Exception($response['tp'][0]['msgList'][0]['message']);
                    }
                    return $response;
                    break;
                default:
                    $curl->close();
                    throw new \Exception(isset($response['message']) ? $response['message'] : 'Ошибка разбора XML');
            }

        } while (true);
    }

    /**
     * Отправка и получение данных
     *
     * @param  string $path   путь к сайту
     * @param  array  $params массив данных если необходимы параметры
     * @param  string $method метод отправки данных
     * @return string         данные страницы в json формате
     */
    public function send($path, array $params = [], $method = 'post')
    {
        $curl = new \Curl\Curl();

        $cookieFile = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'rzd_cookie';

        $curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
        $curl->setCookieFile($cookieFile);
        $curl->setCookieJar($cookieFile);
        $curl->$method($path, $params);
        $curl->close();

        return $curl;
    }

    /**
     * Получение уникального ключа RID
     *
     * @param  string $json данные
     * @return string       уникальный ключ
     * @throws \Exception
     */
    protected function getRid($json)
    {
        foreach (['rid', 'RID'] as $rid){
            if (isset($json[$rid])) {
                return $json[$rid];
            }
        }

        throw new \Exception('Ошибка: Не найден уникальный ключ');
    }

    /**
     * Проверка является ли строка валидным json-объектом
     *
     * @param  string  $string проверяемая строка
     * @return boolean         результат проверки
     */
    protected function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
}
