<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Url;

final class FacebookService implements SocialNetworkService
{
    public static function getShares(Url $url, ?\DateTimeImmutable $lastUpdate) : int
    {
        $getData = json_decode(file_get_contents('https://graph.facebook.com/?id=' . $url->url()));
        return intval($getData->share->share_count);
    }
}