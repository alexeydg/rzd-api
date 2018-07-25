<?php

namespace Rzd;

class Config
{
    private $username;
    private $password;
    private $proxy;
    private $userAgent;
    private $referer;

    /**
     * Set Auth
     *
     * @param string $username
     * @param string $password
     */
    public function setAuth($username, $password): void
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Get Auth
     *
     * @return array
     */
    public function getAuth(): array
    {
        return [
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    /**
     * Set Proxy
     *
     * @param array $params
     */
    public function setProxy(array $params): void
    {
        $this->proxy = $params;
    }

    /**
     * Get Proxy
     *
     * @return array
     */
    public function getProxy(): array
    {
        return [
            'server'   => $this->proxy['server'] ?? null,
            'port'     => $this->proxy['port'] ?? null,
            'username' => $this->proxy['username'] ?? null,
            'password' => $this->proxy['password'] ?? null,
        ];
    }

    /**
     * Set User Agent
     *
     * @param string $userAgent
     */
    public function setUserAgent($userAgent): void
    {
        $this->userAgent = $userAgent;
    }

    /**
     * Get User Agent
     *
     * @return string
     */
    public function getUserAgent():? string
    {
        return $this->userAgent;
    }

    /**
     * Set Referer
     *
     * @param string $referer
     */
    public function setReferer($referer): void
    {
        $this->referer = $referer;
    }

    /**
     * Set Referer
     *
     * @return string
     */
    public function getReferer():? string
    {
        return $this->referer;
    }
}
