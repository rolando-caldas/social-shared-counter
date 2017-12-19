<?php

namespace App\Application;

use App\Domain\Collection\SocialNetworkCollection;
use App\Domain\ValueObject\SocialNetwork;

class SocialNetworkService
{
    public static function defaultNetworks() : SocialNetworkCollection
    {
        return new SocialNetworkCollection([
            new SocialNetwork('Facebook', 0),
            new SocialNetwork('Pinterest', 0),
            new SocialNetwork('Twitter', 0)
        ]);
    }
}