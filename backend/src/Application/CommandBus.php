<?php

namespace App\Application;

class CommandBus
{

    private $session;
    private $handlers;

    public function __construct(TransactionalSession $session)
    {
        $this->session = $session;
        $this->handlers = [];
    }

    public function addHandler(string $commandName, $handler, $transactional = true)
    {
        if (!array_key_exists($commandName, $this->handlers))
        {
            $this->handlers[$commandName] = [
                'handler' => $handler,
                'transactional' => $transactional,
            ];
        }

        return $this;
    }

    public function handle($command) : void
    {
        $commandHandle = $this->handlers[get_class($command)];

        if ($commandHandle === null) {
            throw new \Exception('Handle not defined fot the command ' . get_class($command));

        }

        if ($commandHandle['transactional']) {
            $this->session->executeAtomically(function () use ($commandHandle, $command) {
                $commandHandle['handler']->handle($command);
            });
        } else {
            $commandHandle['handler']->handle($command);
        }

    }
}