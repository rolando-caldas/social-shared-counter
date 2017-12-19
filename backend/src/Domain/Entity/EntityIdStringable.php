<?php

namespace App\Domain\Entity;

use Ramsey\Uuid\Uuid;

trait EntityIdStringable
{
    public static function fromString($id) : self
    {
        if (!Uuid::isValid($id)) {
            throw new \Exception("ID " . $id . " not valid");
        }

        return new self($id);
    }
}