<?php
// DIC configuration
$container = $app->getContainer();
// view renderer
$container['renderer'] = function() use ($container) {
    $settings = $container->get('settings')['renderer'];
    return new \Slim\Views\PhpRenderer($settings['template_path']);
};
// database
$container['db'] = function() use ($container) {
    $servername = "67.205.183.11";
    $username = "chardur";
    $password = "changeme";
    $db = new PDO("mysql:host=$servername;dbname=feed_chardur", $username, $password);

    return $db;
};
// monolog
$container['logger'] = function() use ($container) {
    $settings = $container->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};