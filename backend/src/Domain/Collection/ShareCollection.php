<?php

namespace App\Domain\Collection;

use Ramsey\Collection\AbstractCollection;

final class ShareCollection extends AbstractCollection
{
    public function getType()
    {
        return 'App\\Domain\\Entity\\Share\\Share';
    }
}