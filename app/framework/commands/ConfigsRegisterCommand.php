<?php

declare(strict_types = 1);

namespace Framework\commands;

use Framework\registers\ConfigsRegister;

class ConfigsRegisterCommand implements IRCommand
{
    /** @var ConfigsRegister */
    private $configsRegister;

    public function __construct(ConfigsRegister $configsRegister)
    {
        $this->configsRegister = $configsRegister;
    }

    public function execute()
    {
        $this->configsRegister->register();
    }
}
