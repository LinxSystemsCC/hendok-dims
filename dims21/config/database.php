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

    'default' => env('DB_CONNECTION', 'sqlsrv'),

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
            'host' => '102.37.216.104',
            'port' =>  '1433',
            'database' => 'linxdbDIMSHendok',
            'username' => 'linxDemo',
            'password' =>  '7!3qAd7T',
            'prefix' => '',
            'trust_server_certificate' => true,
        ] ,

        'sqlsrv2' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '102.37.216.104'),
            'port' =>  env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'linxdbDIMSHendok'),
            'username' => env('DB_USERNAME', 'linxDemo'),
            'password' => env('DB_PASSWORD', '7!3qAd7T'),
            'prefix' => '',
            'pooling'  => false,
            'trust_server_certificate' => true,
        ],

        'sqlsrv3' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '102.37.216.104'),
            'port' =>  env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'linxdbDIMSHendok'),
            'username' => env('DB_USERNAME', 'linxDemo'),
            'password' => env('DB_PASSWORD', '7!3qAd7T'),
            'prefix' => '',
            'pooling'  => false,
            'trust_server_certificate' => true,
        ],

        'weights' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '102.37.216.104'),
            'port' =>  env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'linxdbDIMSHendok'),
            'username' => env('DB_USERNAME', 'linxDemo'),
            'password' => env('DB_PASSWORD', '7!3qAd7T'),
            'prefix' => '',
            'pooling'  => false,
        ],

        'wmax' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.216.104',
            'port' =>  '1433',
            'database' => 'WMax',
            'username' => 'linxDemo',
            'password' =>  '7!3qAd7T',
            'prefix' => '',
            'pooling'  => false,
        ],

        'webstore' => [
            'driver' => 'sqlsrv',
            'host' => '102.133.239.108',
            'port' =>  '1444',
            'database' => 'LinxBriefcaseSEAF',
            'username' => 'linxDemo',
            'password' =>  'Convid19',
            'prefix' => '',
            'charset' => 'utf8',
            'pooling'  => false,
        ],

        'linxbriefcase' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.216.104',
            'port' =>  '1433',
            'database' => 'LinxBriefcase',
            'username' => 'linxDemo',
            'password' =>  'Express1433SQL',
            'prefix' => '',
            'pooling'  => false,
        ],

        'linxbriefcaseBackOrders' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.216.104',
            'port' =>  '1433',
            'database' => 'LinxBriefcase',
            'username' => 'linxDemo',
            'password' =>  '7!3qAd7T',
            'prefix' => '',
            'pooling'  => false,
        ],

        'sqlsrv4' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '102.37.216.104'),
            'port' =>  env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'linxdbDIMSHendok'),
            'username' => env('DB_USERNAME', 'linxDemo'),
            'password' => env('DB_PASSWORD', '7!3qAd7T'),
            'prefix' => '',
            'pooling'  => false,
        ],

        'googlemaps' => [
            'driver' => 'sqlsrv',
            'host' => '192.168.0.11',
            'port' =>  '1444',
            'database' => 'linxdbDIMSHendok',
            'username' => 'linxDemo',
            'password' =>  'System2008#',
            'prefix' => '',
            'pooling'  => false,
        ],

        'deals' => [
            'driver' => 'sqlsrv',
            'host' => '154.0.172.185',
            'port' =>  '1444',
            'database' => 'Deals',
            'username' => 'linxDemo',
            'password' =>  'System2008',
            'prefix' => '',
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
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '').'_database'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
