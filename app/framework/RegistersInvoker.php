<?php

namespace Framework;

use Framework\commands\IRCommand;

class RegistersInvoker
{
    public function registerIt(IRCommand $command)
    {
        $command->execute();
    }
}
