<?php

use Predis\Session\Handler;

//twig
$app['twig.path'] = array(__DIR__.'/../src/View');
$app['twig.options'] = array(
    'cache' => __DIR__.'/../var/cache/twig',
    'strict_variables' => false
);

// doctrine
$app['dbs.options'] = array (
    '100days' => array(
        'driver'    => 'pdo_mysql',
        'host'      => '207.66.182.70',
        'dbname'    => '100days',
        'user'      => '100days',
        'password'  => 'dr3vTrprw9K3xzSp',
        'charset'   => 'utf8',
    )
);

// redis
$app['predis.clients'] = array(
    'db' => array(
        'parameters' => 'tcp://127.0.0.1:6379',
        'options' => array(
            'prefix' => 'db:'
        ),
    ),
    'session' => array(
        'parameters' => 'tcp://127.0.0.1:6379',
        'options' => array(
            'prefix' => 'sessions:'
        ),
    ),
);

// session
$app['session.storage.handler'] = $app->share(function () use ($app) {
    $client = $app['predis']['session'];
    $options = array('gc_maxlifetime' => 3600);
    $handler = new Handler($client, $options);
    return $handler;
});
$app['session.storage.options'] = array(
    'lifetime' => 3600
);

// security
$app['security.firewalls'] = array(
    'profiler' => array('pattern' => '^/(_(profiler|wdt)|css|images|js)/'),
    'login' => array('pattern' => '^/login/$'),
    'default' => array(
        'pattern' => '^.*$',
        'remember_me' => array(
            'key'                => '100daychallenge',
            'always_remember_me' => true,
        ),
        'form' => array(
            'login_path' => '/login/',
            'check_path' => '/login_check',
        ),
        'logout' => array('logout_path' => '/logout'),
        'users' => $app->share(function () use ($app) {
            return new Days\Security\UserProvider($app['dbs']['100days']);
        }),
    ),
);

// swiftmail with mandril
$app['swiftmailer.options'] = array(
    'host' => 'smtp.mandrillapp.com',
    'port' => '587',
    'username' => 'thomas@sctr.net',
    'password' => 'pGl9EPM5tI7b292Y5OU7Qg'
);
