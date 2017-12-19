<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;

class EntityId
{
    private $id;

    public function __construct($id = null)
    {
        $this->id = $id ?: Uuid::uuid4()->toString();
    }

    public function id() : string
    {
        return $this->id;
    }

    public function equals(EntityId $entityId) : bool
    {
        return $this->id() === $entityId->id();
    }

    public function __toString() : string
    {
        return $this->id();
    }
}