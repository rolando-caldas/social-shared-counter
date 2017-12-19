<?php

namespace App\Domain\Entity\Share;

use App\Domain\DomainEvent;

final class ShareWasPersisted extends DomainEvent
{
    public function __construct(ShareId $id)
    {
        parent::__construct($id);
    }
}