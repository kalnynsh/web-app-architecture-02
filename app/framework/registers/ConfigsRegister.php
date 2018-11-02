<?php

declare(strict_types = 1);

namespace Framework\registers;

use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;

/**
 * @property ContainerBuilder $containerBuilder
 * @property FileLocator $fileLocator
 * @property PhpFileLoader $fileLoader
 */
class ConfigsRegister
{
    protected $containerBuilder;

    public function __construct(
        ContainerBuilder $containerBuilder
    ) {
        $this->containerBuilder = $containerBuilder;
    }

    public function register(): void
    {
        try {
            $fileLocator = new FileLocator(CONFIG);
            $loader = new PhpFileLoader($this->containerBuilder, $fileLocator);
            $loader->load('parameters.php');
        } catch (Throwable $e) {
            die('Cannot read the config file. File: ' . __FILE__ . '. Line: ' . __LINE__);
        }
    }
}
