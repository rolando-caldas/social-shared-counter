<?php

namespace App\Application\Share\Command;

use App\Application\Command;

final class ShareRemoveCommand implements Command
{
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function uuid() : string
    {
        return $this->uuid;
    }
}