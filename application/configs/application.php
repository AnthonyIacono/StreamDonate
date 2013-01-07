<?php

$config = array(
    'debug' => true,
    'version' => '1.0.0',
    'paths' => array(
        'domain_relative' => '/',
        'framework' => dirname(dirname(__DIR__)) . '/framework/',
        'application' => dirname(__DIR__) . '/',
        'web_root' => dirname(dirname(__DIR__)) . '/',
        'base_url' => 'http://localhost/',
        'cache' => dirname(__DIR__) . '/cache/',
        'fonts' => dirname(dirname(__DIR__)) . '/fonts/'
    ),
    'server_timezone' => date_default_timezone_get()
);
