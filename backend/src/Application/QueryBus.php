<?php

namespace App\Application;

class QueryBus
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

    public function handle($command)
    {
        $commandHandle = $this->handlers[get_class($command)];

        if ($commandHandle === null) {
            throw new \Exception('Handle not defined for the query ' . get_class($command));
        }

        $return = null;

        if ($commandHandle['transactional']) {
            $return = $this->session->executeAtomically(function () use ($commandHandle, $command) {
                return $commandHandle['handler']->handle($command);
            });
        } else {
            $return = $commandHandle['handler']->handle($command);
        }

        return is_array($return) || is_object($return) ? $return : [];
    }
}