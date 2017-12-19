<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Url;

interface SocialNetworkService
{
    public static function getShares(Url $url, ?\DateTimeImmutable $lastUpdate) : int;
}