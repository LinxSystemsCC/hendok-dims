<?php

use Illuminate\Support\Str;

return [

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

    'default' => env('DB1_CONNECTION', 'sqlsrv'),

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

    'connections' => [

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB1_HOST', 'host'),
            'port' =>  env('DB1_PORT', 'port'),
            'database' => env('DB1_DATABASE', 'database'),
            'username' => env('DB1_USERNAME', 'username'),
            'password' =>  env('DB1_PASSWORD', 'password'),
            'prefix' => '',
			'encrypt' => 'yes',
			'trust_server_certificate' => true,

        ],
        
        'sqlsrv2' => [
			'driver' => 'sqlsrv',
            'host' => env('DB1_HOST', 'host'),
            'port' =>  env('DB1_PORT', 'port'),
            'database' => env('DB1_DATABASE', 'database'),
            'username' => env('DB1_USERNAME', 'username'),
            'password' =>  env('DB1_PASSWORD', 'password'),
            'prefix' => '',
			'encrypt' => 'yes',
			'trust_server_certificate' => true,
        ],

        'sqlsrv3' => [
			'driver' => 'sqlsrv',
            'host' => env('DB1_HOST', 'host'),
            'port' =>  env('DB1_PORT', 'port'),
            'database' => env('DB1_DATABASE', 'database'),
            'username' => env('DB1_USERNAME', 'username'),
            'password' =>  env('DB1_PASSWORD', 'password'),
            'prefix' => '',
			'encrypt' => 'yes',
			'trust_server_certificate' => true,
            'pooling'  => false,
        ],

        'sqlsrv4' => [
			'driver' => 'sqlsrv',
            'host' => env('DB1_HOST', 'host'),
            'port' =>  env('DB1_PORT', 'port'),
            'database' => env('DB1_DATABASE', 'database'),
            'username' => env('DB1_USERNAME', 'username'),
            'password' =>  env('DB1_PASSWORD', 'password'),
            'prefix' => '',
			'encrypt' => 'yes',
			'trust_server_certificate' => true,
            'pooling'  => false,
        ],

		'weights' => [
            'driver' => 'sqlsrv',
            'host' => env('DB2_HOST', 'host'),
            'port' =>  env('DB2_PORT', 'port'),
            'database' => env('DB2_DATABASE', 'database'),
            'username' => env('DB2_USERNAME', 'username'),
            'password' =>  env('DB2_PASSWORD', 'password'),
            'prefix' => '',
			'encrypt' => 'yes',
			'trust_server_certificate' => true,
            'pooling'  => false,
        ],

        'googlemaps' => [
            'driver' => 'sqlsrv',
            'host' => env('DB1_HOST', 'host'),
            'port' =>  env('DB1_PORT', 'port'),
            'database' => env('DB1_DATABASE', 'database'),
            'username' => env('DB1_USERNAME', 'username'),
            'password' =>  env('DB1_PASSWORD', 'password'),
            'prefix' => '',
			'encrypt' => 'yes',
			'trust_server_certificate' => true,
            'pooling'  => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', 'host'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', 'host'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
    ],

];
