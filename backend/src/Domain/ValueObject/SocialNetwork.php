<?php

namespace App\Domain\ValueObject;

final class SocialNetwork
{
    private $name;
    private $counter;

    public function __construct(string $name, int $counter)
    {
        $this->name = $name;
        $this->counter = $counter;
    }

    public function name() : string
    {
        return $this->name;
    }

    public function counter() : int
    {
        return $this->counter;
    }
}