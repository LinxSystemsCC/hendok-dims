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

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

            'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.0.48',
            'port' =>  '1492',
            'database' => 'linxdbdims',
            'username' => 'sa',
            'password' =>  'System2016#',
            'prefix' => ''

        ],
        'sqlsrv2' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.0.48',
            'port' =>  '1492',
            'database' => 'linxdbdims',
            'username' => 'sa',
            'password' =>  'System2016#',
            'prefix' => '',
            'pooling'  => false,
        ],
        'sqlsrv3' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.0.48',
            'port' =>  '1492',
            'database' => 'linxdbdims',
            'username' => 'sa',
            'password' =>  'System2016#',
            'prefix' => '',
            'pooling'  => false,
        ],
        
        'webstore' => [
            'driver' => 'sqlsrv',
            'host' => '102.133.239.108',
            'port' =>  '1433',
            'database' => 'LinxBriefcaseSEAF',
            'username' => 'sa',
            'password' =>  'Convid19',
            'prefix' => '',
            'charset' => 'utf8',
            'pooling'  => false,
        ],
          'linxbriefcase' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.14.76',
            'port' =>  '61994',
            'database' => 'LinxBriefcase',
            'username' => 'sa',
            'password' =>  'Express62019SQL',
            'prefix' => '',
            'pooling'  => false,
              /*'driver' => 'sqlsrv',
              'host' => '102.37.14.76',
              'port' =>  '61994',
              'database' => 'LinxBriefcase',
              'username' => 'sa',
              'password' =>  'Express62019SQL',
              'prefix' => '',
              'pooling'  => false,*/


          ],
        'linxbriefcaseBackOrders' => [
            'driver' => 'sqlsrv',
            'host' => '.',
            'port' =>  '1433',
            'database' => 'LinxBriefcase',
            'username' => 'sa',
            'password' =>  'Linx_123',
            'prefix' => '',
            'pooling'  => false,
            /*'driver' => 'sqlsrv',
            'host' => '102.37.14.76',
            'port' =>  '61994',
            'database' => 'LinxBriefcase',
            'username' => 'sa',
            'password' =>  'Express62019SQL',
            'prefix' => '',
            'pooling'  => false,*/


        ],

        'sqlsrv4' => [
            'driver' => 'sqlsrv',
            'host' => '102.37.0.48',
            'port' =>  '1492',
            'database' => 'linxdbdims',
            'username' => 'sa',
            'password' =>  'System2016#',
            'prefix' => '',
            'pooling'  => false,

        ],
  'googlemaps' => [
            'driver' => 'sqlsrv',
            'host' => '192.168.0.11',
            'port' =>  '1433',
            'database' => 'linxdbDIMS',
            'username' => 'sa',
            'password' =>  'System2008#',
            'prefix' => '',
            'pooling'  => false,

        ],


        /***
        THIS IS FOR PREMISES**/
/*
        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => '.',
            'port' =>  '1433',
            'database' => 'linxdbDIMSMag',
            'username' => 'sa',
            'password' =>  'Linx_123',
            'prefix' => ''

        ],
        'sqlsrv2' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '.'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'linxdbDIMS'),
            'username' => env('DB_USERNAME', 'sa'),
            'password' => env('DB_PASSWORD', 'Linx_123'),
            'prefix' => '',
            'pooling'  => false,

        ],
        'sqlsrv3' => [
            'driver' => 'sqlsrv',
            'host' => '192.168.1.129',
            'port' =>  '1433',
            'database' => 'linxdbDIMS',
            'username' => 'sa',
            'password' =>  'gR0!1248$',
            'prefix' => '',
            'pooling'  => false,

        ],
        'sqlsrv4' => [
            'driver' => 'sqlsrv',
            'host' => '.',
            'port' =>  '1433',
            'database' => 'linxdbDIMSMag',
            'username' => 'sa',
            'password' =>  'Linx_123',
            'prefix' => '',
            'pooling'  => false,

        ],*/

        'deals' => [
            'driver' => 'sqlsrv',
            'host' => '154.0.172.185',
            'port' =>  '1433',
            'database' => 'Deals',
            'username' => 'sa',
            'password' =>  'System2008',
            'prefix' => '',
            'pooling'  => false,

        ],
        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', '.'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
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
