<?php

namespace Rzd;

use Exception;
use nokogiri;

class Auth
{
    protected $loginPath = 'https://pass.rzd.ru/timetable/j_security_check/ru';

    protected $profilePath = 'https://pass.rzd.ru/selfcare/editProfile/ru';

    private $query;

    public function __construct()
    {
        $this->query = new Query();
    }

    /**
     * Авторизация на сайте pass.rzd.ru
     *
     * @param  string $username логин пользователя
     * @param  string $password пароль пользователя
     * @return boolean          результат авторизации
     * @throws Exception
     */
    public function login($username, $password)
    {
        $params = [
            'j_username' => $username,
            'j_password' => $password,
        ];

        $query = $this->query->send($this->loginPath, $params);

        $cookies = $query->responseCookies;

        return isset($cookies['AuthFlag']) && $cookies['AuthFlag'] == 'true';
    }

    /**
     * Метод чтения страниц
     *
     * @param  string $path адрес страницы
     * @param  array  $params
     * @return string       html-код страницы
     * @throws Exception
     */
    public function page($path, array $params = [])
    {
        return $this->query->send($path, $params)->response;
    }

    /**
     * Получение данных пользователя
     *
     * @return array массив данных пользователя
     * @throws Exception
     */
    public function getProfile()
    {
        $profile = $this->page($this->profilePath);

        $saw = new nokogiri($profile);

        // Здесь чуть не доработано, селекты нужно отдельно парсить
        $dataProfile = $saw->get('form.selfcareForm input')->toArray();

        $profile = [];

        // Игнорируем ненужные поля
        $ignoreName = ['userpassword', 'userpassword_CONFIRM', 'DATA'];

        foreach($dataProfile as $data) {

            if (empty($data['name']) || in_array($data['name'], $ignoreName, true)) {
                continue;
            }

            $profile[$data['name']] = isset($data['value']) ? $data['value'] : '';
        }

        return $profile;
    }

    /**
     * Сохранение профиля
     *
     * @param  array $data данные профиля
     * @return boolean     результат сохраниения
     * @throws Exception
     */
    public function setProfile($data)
    {
        $user    = $this->getProfile();
        $profile = $this->page($this->profilePath, array_merge($user, $data));

        $saw = new nokogiri($profile);

        $result = $saw->get('.warningBlock')->toText();

        return $result === 'Профиль пользователя успешно изменен';
    }
}
