<?php
require __DIR__ . '/vendor/autoload.php';


$curl = new \Curl\Curl();

		$curl->setOpt(CURLOPT_FOLLOWLOCATION, true);
		$curl->setCookieFile('cookie.txt');
		$curl->setCookieJar('cookie.txt');

$cookies = $curl->getResponseCookies();
				foreach ($cookies as $key=>$value){
					$curl->setCookie($key, $value);
				}

		$curl->get('http://visavi.net/index.php', ['login' => 'Vantuz', 'pass' => '']);
echo '<pre>';
print_r($curl->response);
$curl->close();
exit;


$auth = new Auth();

$username = 'vantuzilla';
$password = 'qwe123qwe';

echo '<pre>';
print_r($auth->login($username, $password));
