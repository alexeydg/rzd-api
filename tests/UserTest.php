<?php

use PHPUnit\Framework\TestCase;
use Visavi\Auth;

class UserTest extends TestCase
{
    protected function setUp()
    {
        $this->auth = new Auth();
    }

    /**
     * Тест авторизации
     */
    public function testLogin()
    {
        // Проверка авторизации
        if (empty(USERNAME) || empty(PASSWORD)) {
            $this->markTestSkipped('Установите логин и пароль в файле bootstrap.php');
        } else {
            $this->assertTrue($this->auth->login(USERNAME, PASSWORD));
        }
    }

    /**
     * Тест получения данных
     */
    public function testProfile()
    {
        $dataProfile = $this->auth->getProfile();

        if (empty($dataProfile)) {
            $this->markTestSkipped('Не удалось авторизоваться на сайте');
        } else {
            $this->assertTrue(is_array($dataProfile));
        }
    }

    /**
     * Тест обновления данных
     */
    public function testUpdate()
    {
        $dataProfile = $this->auth->getProfile();

        if (empty($dataProfile)) {
            $this->markTestSkipped('Не удалось авторизоваться на сайте');
        } else {

            $replaceData = [
                'MIDDLE_NAME'      => 'Владимирович',
                'ACCEPT_POST_FLAG' => 1,
                'GENDER_ID'        => 2,
                'QUESTION_ID'      => 1,
            ];

            $this->assertTrue($this->auth->setProfile(array_merge($dataProfile, $replaceData)));
        }
    }
}
