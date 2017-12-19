<?php

namespace App\Application\Share\Query;

use App\Application\Query;

final class ShareInfoQuery implements Query
{
    private $uuid;

    public function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    public function id() : string
    {
        return $this->uuid;
    }

}