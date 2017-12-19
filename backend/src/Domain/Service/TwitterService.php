<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Url;

final class TwitterService implements SocialNetworkService
{
    public static function getShares(Url $url, ?\DateTimeImmutable $lastUpdate) :int
    {
        // @todo extract counter of last tweets that contain de URL
        return 0;
    }
}