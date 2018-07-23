<h1>Примеры запросов</h1>

<div style="background: sandybrown; padding: 5px; font-weight: bold">
    Обращаем внимание на то, что по новым условиям RZD.RU дату отправки нужно указывать с учетом часового пояса станции отправления
</div>

<h3>Выбор маршрута в одну сторону</h3>
<a href="/examples/train_routes.php">Просмотр</a><br>
В примере выполняется поиск маршрута САНКТ-ПЕТЕРБУРГ - МОСКВА (только с билетами) на завтра

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'dir'        => 0,
    'tfl'        => 3,
    'checkSeats' => 0,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => 'дата на завтра',
];

$routes = $api->trainRoutes($params)
</pre>

<h3>Выбор маршрута туда-обратно</h3>
<a href="/examples/train_routes_return.php">Просмотр</a><br>
В примере выполняется поиск маршрута САНКТ-ПЕТЕРБУРГ - МОСКВА (только с билетами) на завтра туда и через 5 дней обратно

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'dir'        => 1,
    'tfl'        => 3,
    'checkSeats' => 0,
    'code0'      => '2004000',
    'code1'      => '2000000',
    'dt0'        => 'дата на завтра',
    'dt1'        => 'дата через 5 дней',
];

$routes = $api->trainRoutesReturn($params);
</pre>

<h3>Выбор вагонов</h3>
<a href="/examples/train_carriages.php">Просмотр</a><br>
В примере выполняется просмотр всех вагонов в поезде в направлением САНКТ-ПЕТЕРБУРГ - МОСКВА на завтра

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'dir'   => 0,
    'code0' => '2004000',
    'code1' => '2000000',
    'dt0'   => 'дата на завтра',
    'time0' => 'время отправления',
    'tnum0' => 'номер вагона',
];

$carriages = $api->trainCarriages($params)
</pre>

<h3>Просмотр станций</h3>
<a href="/examples/train_station_list.php">Просмотр</a><br>
В примере выполняется поиск всех станций остановок для поезда номер 072E на завтра

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$params = [
    'train_num' => '072Е',
    'date'      => 'дата на завтра',
];

$stations = $api->trainStationList($params);
</pre>


<h3>Просмотр списка кодов станций</h3>
<a href="/examples/station_code.php">Просмотр</a><br>
В примере выполняется поиск кодов станций начинающихся с ЧЕБ

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$api = new Rzd\Api();

$params = [
    'stationNamePart' => 'ЧЕБ',
    'lang'            => 'ru',
    'compactMode'     => 'y',
];

$stations = $api->stationCode($params);
</pre>

<h3>Авторизация пользователя</h3>
<a href="/examples/user_login.php">Авторизация</a><br>
В примере выполняется авторизация на сайте rzd.ru, возвращает true и устанавливает куки если авторизация выполнена успешно

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$auth = new Rzd\Auth();

$auth->login('логин', 'пароль');
</pre>

<h3>Просмотр профиля пользователя</h3>
<a href="/examples/user_profile.php">Просмотр</a><br>
В примере выполняется просмотр данных профиля, для выполнения успешного запроса сперва необходимо авторизоваться

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$auth = new Rzd\Auth();

$dataProfile = $auth->getProfile();
</pre>


<h3>Изменение профиля пользователя</h3>
<a href="/examples/user_update.php">Изменить</a><br>
В примере выполняется обновление профиля пользователя

<pre style="background: aliceblue; padding: 5px; border: 1px solid brown">
$auth = new Rzd\Auth();

$replaceData = [
    'MIDDLE_NAME'      => 'Владимирович',
    'ACCEPT_POST_FLAG' => 1,
    'GENDER_ID'        => 2,
    'QUESTION_ID'      => 1,
];

$auth->setProfile($replaceData);
</pre>
