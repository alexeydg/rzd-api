<?php

namespace Rzd;

use Exception;

class Auth
{
    /**
     * Страница авторизации
     *
     * @var string
     */
    protected $loginPath = 'https://m.rzd.ru/selfcare/j_security_check/ru';

    /**
     * Страница профиля
     *
     * @var string
     */
    protected $profilePath = 'https://m.rzd.ru/selfcare/user';

    /**
     * @var Query
     */
    private $query;
    /**
     * @var Config
     */
    private $config;

    /**
     * Auth constructor.
     *
     * @param Config|null $config
     * @throws Exception
     */
    public function __construct(Config $config = null)
    {
        if (! $config) {
            $config = new Config();
        }

        $this->config = $config;
        $this->query  = new Query($this->config);
    }

    /**
     * Авторизация на сайте pass.rzd.ru
     *
     * @return boolean результат авторизации
     * @throws Exception
     */
    public function login(): bool
    {
        $this->query->send($this->loginPath, $this->config->getAuth());

        return $this->getProfile() ? true : false;
    }

    /**
     * Получение данных пользователя
     *
     * @return string массив данных пользователя
     * @throws Exception
     */
    public function getProfile():? string
    {
        $profile = (array) $this->query->get($this->profilePath, [], 'get');

        return $profile ? json_encode($profile) : null;
    }
}
