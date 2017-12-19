<?php

namespace App\Application\Share\Query;

use App\Application\Query;

final class ShareListQuery implements Query
{
    private $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }

    public function date() : string
    {
         return $this->date;
    }
}