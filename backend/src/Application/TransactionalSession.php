<?php

namespace App\Application;

interface TransactionalSession
{
    public function executeAtomically(callable $operation);
}