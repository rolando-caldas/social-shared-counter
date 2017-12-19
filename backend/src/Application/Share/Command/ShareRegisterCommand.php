<?php

namespace App\Application\Share\Command;

use App\Application\Command;

final class ShareRegisterCommand implements Command
{
    private $uuid;
    private $url;

    public function __construct(string $uuid, string $url)
    {
        $this->uuid = $uuid;
        $this->url = $url;
    }

    public function uuid() : string
    {
        return $this->uuid;
    }

    public function url() : string
    {
        return $this->url;
    }
}