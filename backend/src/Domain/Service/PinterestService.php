<?php

namespace App\Domain\Service;

use App\Domain\ValueObject\Url;

final class PinterestService implements SocialNetworkService
{
    public static function getShares(Url $url, ?\DateTimeImmutable $lastUpdate) : int
    {
        $getData = file_get_contents('https://api.pinterest.com/v1/urls/count.json?url=' . $url->url());
        $data = json_decode(preg_replace( '/^receiveCount\((.*)\)$/', '$1', $getData ));
        return intval($data->count);
    }
}