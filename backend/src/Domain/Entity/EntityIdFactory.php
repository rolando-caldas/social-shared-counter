<?php

namespace App\Domain\Entity;

use App\Domain\Entity\Share\ShareId;
use Ramsey\Uuid\Uuid;

class EntityIdFactory
{
    public function nextIdentity() : string
    {
        return Uuid::uuid4()->toString();
    }

    public function share() : ShareId
    {
        return new ShareId();
    }

    public function shareFromString(string $id) : ShareId
    {
        return ShareId::fromString($id);
    }
}