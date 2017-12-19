<?php

namespace App\Infrastructure\Domain\Entity\Share;

use App\Infrastructure\Domain\Entity\DoctrineEntityId;

final class DoctrineShareId extends DoctrineEntityId
{
    public function getName()
    {
        return 'ShareId';
    }

    protected function getNamespace()
    {
        return 'App\Domain\Entity\Share';
    }
}