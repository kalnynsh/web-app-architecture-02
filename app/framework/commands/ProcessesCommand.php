<?php

declare(strict_types = 1);

namespace Framework\commands;

use Symfony\Component\HttpFoundation\Request;
use Framework\processors\RequestProcessor;
use Framework\commands\IRCommand;

/**
 * ProcessesCommand class
 *
 * @property RequestProcessor $requestProcessor
 * @property RouteCollection $routeCollection
 * @property Request $request
 */
class ProcessesCommand implements IRCommand
{
    private $requestProcessor;
    private $request;

    public function __construct(
        RequestProcessor $requestProcessor,
        Request $request
    ) {
        $this->requestProcessor = $requestProcessor;
        $this->request = $request;
    }

    public function execute()
    {
        return $this
                ->requestProcessor
                ->processRequest($this->request);
    }
}
