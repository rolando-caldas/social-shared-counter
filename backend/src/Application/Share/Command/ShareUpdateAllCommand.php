<?php

namespace App\Application\Share\Command;

use App\Application\Command;

final class ShareUpdateAllCommand implements Command
{
    private $date;

    public function __construct(string $date = '')
    {
        $this->date = $date;
    }

    public function date() : string
    {
        return $this->date;
    }
}