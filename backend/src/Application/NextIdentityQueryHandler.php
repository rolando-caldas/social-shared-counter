<?php

namespace App\Application;

use App\Domain\Entity\EntityIdFactory;

class NextIdentityQueryHandler
{
    private $entityIdFactory;

    public function __construct(EntityIdFactory $entityIdFactory)
    {
        $this->entityIdFactory = $entityIdFactory;
    }

    public function handle(NextIdentityQuery $query) : array
    {
        return ['uuid' => $this->entityIdFactory->nextIdentity()];
    }
}