<?php

// Enable PHP Error level
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// Enable debug mode
$app['debug'] = true;

// Doctrine (db)
$app['db.options'] = array(
    'driver' => 'pdo_mysql',
    'host' => 'psqt.myinfomaniak.com',
    'dbname' => 'psqt_roussel',
    'user' => 'psqt_roussel',
    'password' => 't558gfkx3crom147',
);
