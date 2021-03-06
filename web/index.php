<?php

defined('ROOT') or define('ROOT', dirname(__DIR__));
defined('APP') or define('APP', ROOT . DIRECTORY_SEPARATOR . 'app');
defined('CONFIG') or define('CONFIG', APP . DIRECTORY_SEPARATOR . 'config');

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Framework\registers\RoutesRegister;
use Framework\registers\ConfigsRegister;
use Framework\commands\RoutesRegisterCommand;
use Framework\commands\ConfigsRegisterCommand;

require_once ROOT . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$request = Request::createFromGlobals();
$containerBuilder = new ContainerBuilder();
Framework\Registry::addContainer($containerBuilder);

$configsRegister = new ConfigsRegister($containerBuilder);
$routesRegister = new RoutesRegister($containerBuilder);

$configsCommand = new ConfigsRegisterCommand($configsRegister);
$routesCommand = new RoutesRegisterCommand($routesRegister);

$kernel = new Kernel(
    $containerBuilder,
    $configsCommand,
    $routesCommand
);

$response = $kernel->handle($request);
$response->send();
