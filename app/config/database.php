<?php

// もし migration を appfog の mysql に対して実行したい場合は、
// af tunnel コマンドの結果で下記設定を埋めて下さい。
// appfog は ssh ログインは出来ませんので、ローカルからVPN接続して mysql を叩きます。
//
// Starting tunnel to YOUR_SERVICE_NAME on port 10000.
// 1: none
// 2: mysql
// 3: mysqldump
// Which client would you like to start?:
//
// このような表示になったら、1を入力してそのままにして下記3つの設定を埋めます。
//
// 保存したら(tunnelを実行しているのとは)別のターミナルを立ち上げ、下記コマンドを実行します。
// cd YOUR_APP_DIR
// php artisan migrate:install --env=production
// php artisan migrate --env=production
// 以上で migration は完了です。
$mysql_dbname = '';
$mysql_user = '';
$mysql_password = '';
// af tunnel で接続中は 127.0.0.1:10000 が appfog の mysql を向きます。
$mysql_host = '127.0.0.1';
$mysql_port = '10000';

$redis_host = null;
$redis_port = null;
$redis_password = null;

// for appfog config
$services_json = getenv('VCAP_SERVICES');
if ($services_json !== false) {
    $services = json_decode($services_json, true);
    $config_mysql = null;
    $config_redis = null;
    foreach ($services as $name => $service) {
        if (0 === stripos($name, 'mysql')) {
            $config_mysql = $service[0]['credentials'];
            continue;
        }
        if (0 === stripos($name, 'redis')) {
            $config_redis = $service[0]['credentials'];
            continue;
        }
    }
    is_null($config_mysql) && die('MySQL service information not found.');
    $mysql_host = $config_mysql["hostname"];
    $mysql_port = $config_mysql["port"];
    $mysql_dbname = $config_mysql["name"];
    $mysql_user = $config_mysql["user"];
    $mysql_password = $config_mysql["password"];
    is_null($config_redis) && die('Redis service information not found.');
    $redis_host = $config_redis["hostname"];
    $redis_port = $config_redis["port"];
    $redis_password = $config_redis["password"];
}

return array(

	/*
	|--------------------------------------------------------------------------
	| PDO Fetch Style
	|--------------------------------------------------------------------------
	|
	| By default, database results will be returned as instances of the PHP
	| stdClass object; however, you may desire to retrieve records in an
	| array format for simplicity. Here you can tweak the fetch style.
	|
	*/

	'fetch' => PDO::FETCH_CLASS,

	/*
	|--------------------------------------------------------------------------
	| Default Database Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify which of the database connections below you wish
	| to use as your default connection for all database work. Of course
	| you may use many connections at once using the Database library.
	|
	*/

	'default' => 'mysql',

	/*
	|--------------------------------------------------------------------------
	| Database Connections
	|--------------------------------------------------------------------------
	|
	| Here are each of the database connections setup for your application.
	| Of course, examples of configuring each database platform that is
	| supported by Laravel is shown below to make development simple.
	|
	|
	| All database work in Laravel is done through the PHP PDO facilities
	| so make sure you have the driver for your particular database of
	| choice installed on your machine before you begin development.
	|
	*/

	'connections' => array(

		'sqlite' => array(
			'driver'   => 'sqlite',
			'database' => __DIR__.'/../database/production.sqlite',
			'prefix'   => '',
		),

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => 'localhost',
			'database'  => 'database',
			'username'  => 'root',
			'password'  => '',
			'charset'   => 'utf8',
			'collation' => 'utf8_unicode_ci',
			'prefix'    => '',
		),

		'pgsql' => array(
			'driver'   => 'pgsql',
			'host'     => 'localhost',
			'database' => 'database',
			'username' => 'root',
			'password' => '',
			'charset'  => 'utf8',
			'prefix'   => '',
			'schema'   => 'public',
		),

		'sqlsrv' => array(
			'driver'   => 'sqlsrv',
			'host'     => 'localhost',
			'database' => 'database',
			'username' => 'root',
			'password' => '',
			'prefix'   => '',
		),

	),

	/*
	|--------------------------------------------------------------------------
	| Migration Repository Table
	|--------------------------------------------------------------------------
	|
	| This table keeps track of all the migrations that have already run for
	| your application. Using this information, we can determine which of
	| the migrations on disk have not actually be run in the databases.
	|
	*/

	'migrations' => 'migrations',

	/*
	|--------------------------------------------------------------------------
	| Redis Databases
	|--------------------------------------------------------------------------
	|
	| Redis is an open source, fast, and advanced key-value store that also
	| provides a richer set of commands than a typical key-value systems
	| such as APC or Memcached. Laravel makes it easy to dig right in.
	|
	*/

	'redis' => array(

		'cluster' => true,

		'default' => array(
			'host'     => '127.0.0.1',
			'port'     => 6379,
			'database' => 0,
		),

	),

);
