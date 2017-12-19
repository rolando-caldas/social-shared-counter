<?php

namespace App\Application\Share\Command;

use App\Application\Command;

final class ShareUpdateItemCommand implements Command
{
    private $uuid;
    private $date;

    public function __construct(string $uuid, string $date)
    {
        $this->uuid = $uuid;
        $this->date = $date;
    }

    public function id() : string
    {
        return $this->uuid;
    }

    public function date() : string
    {
        return $this->date;
    }
}