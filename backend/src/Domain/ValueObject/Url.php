<?php

namespace App\Domain\ValueObject;

final class Url
{
    private $url;

    public function __construct(string $url) {
        $this->urlIsValidOrFail($url);
        $this->url = $url;
    }

    private function urlIsValidOrFail(string $url) : void
    {

    }

    public function url() : string
    {
        return $this->url;
    }
}