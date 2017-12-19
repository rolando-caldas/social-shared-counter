<?php

namespace App\Application;

use App\Domain\Entity\EntityIdFactory;

class CommandHandler
{
    protected $entityIdFactory;

    public function __construct(EntityIdFactory $entityIdFactory)
    {
        $this->entityIdFactory = $entityIdFactory;
    }
}