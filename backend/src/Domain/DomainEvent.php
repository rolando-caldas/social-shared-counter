<?php

namespace App\Domain;

use App\Domain\Entity\EntityId;

abstract class DomainEvent
{
    protected $id;
    protected $occurredOn;

    public function __construct(EntityId $id)
    {
        $this->id = $id;
        $this->occurredOn = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));
    }

    public function id() : EntityId {
        return $this->id;
    }

    public function occurredOn() : \DateTimeImmutable
    {
        return $this->occurredOn;
    }
}