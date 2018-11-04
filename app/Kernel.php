<?php

declare (strict_types = 1);

use Framework\commands\ConfigsRegisterCommand;
use Framework\commands\ProcessesCommand;
use Framework\commands\RoutesRegisterCommand;
use Framework\processors\RequestProcessor;
use Framework\registers\ConfigsRegister;
use Framework\registers\RoutesRegister;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;

/**
 * Kernel class
 *
 * @property RouteCollection $routeCollection
 * @property ContainerBuilder $containerBuilder
 * @property ConfigsRegisterCommand $configsCommand
 * @property RoutesRegisterCommand $routesCommand
 * @property ProcessesCommand $processesCommand
 */
class Kernel
{
    protected $configsCommand;
    protected $routesCommand;

    public function __construct(
        ContainerBuilder $containerBuilder,
        ConfigsRegisterCommand $configsCommand,
        RoutesRegisterCommand $routesCommand
    ) {
        $this->containerBuilder = $containerBuilder;
        $this->configsCommand = $configsCommand;
        $this->routesCommand = $routesCommand;
    }

    /**
     * @return void
     */
    protected function registerConfigs(): void
    {
        $this->configsCommand->execute();
    }

    /**
     * @return void
     */
    protected function registerRoutes(): void
    {
        $this->routesCommand->execute();
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function handle(Request $request): Response
    {
        $this->registerConfigs();
        $this->registerRoutes();

        return $this->process($request);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function process(Request $request): Response
    {
        $routeCollection = $this->containerBuilder->get('route_collection');
        $requestProcessor = new RequestProcessor($routeCollection);
        $processesCommand = new ProcessesCommand($requestProcessor, $request);

        return $processesCommand->execute();
    }
}
