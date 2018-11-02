<?php

declare(strict_types = 1);

namespace Framework\registers;

use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * @property ContainerBuilder $containerBuilder
 */
class RoutesRegister
{
    protected $containerBuilder;

    public function __construct(
        ContainerBuilder $containerBuilder
    ) {
        $this->containerBuilder = $containerBuilder;
    }

    public function register(): void
    {
        $routeCollection = require_once CONFIG . DIRECTORY_SEPARATOR . 'routing.php';

        $this->containerBuilder->set('route_collection', $routeCollection);
    }
}
