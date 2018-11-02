<?php

declare(strict_types = 1);

namespace Framework\commands;

use Framework\registers\RoutesRegister;

class RoutesRegisterCommand implements IRCommand
{
    /** @var RoutesRegister */
    private $routesRegister;

    public function __construct(RoutesRegister $routesRegister)
    {
        $this->routesRegister = $routesRegister;
    }

    public function execute()
    {
        $this->routesRegister->register();
    }
}
