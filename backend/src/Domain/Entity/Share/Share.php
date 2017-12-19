<?php

namespace App\Domain\Entity\Share;

use App\Domain\Collection\SocialNetworkCollection;
use App\Domain\ValueObject\SocialNetwork;
use App\Domain\ValueObject\Url;

final class Share
{
    private $id;
    private $url;
    private $socialNetwork;
    private $lastUpdated;

    private function __construct(ShareId $id, Url $url)
    {
        $this->id = $id;
        $this->url = $url;
        $this->initiateSocialNetwork();
    }

    private function initiateSocialNetwork()
    {
        $this->socialNetwork = new SocialNetworkCollection();
    }

    public static function add(ShareId $id, Url $url) : self
    {
        return new self($id, $url);
    }

    public static function addWithSocialNetworks(ShareId $id, Url $url, SocialNetworkCollection $socialNetwork) : self
    {
        $share = new self($id, $url);
        $share->overrideSocialNetwork($socialNetwork);

        return $share;
    }

    private function overrideSocialNetwork(SocialNetworkCollection $socialNetworkCollection) : void
    {
        $this->socialNetwork = $socialNetworkCollection;
    }

    public function id() : ShareId
    {
        return $this->id;
    }

    public function url() : Url
    {
        return $this->url;
    }

    public function socialNetwork() : SocialNetworkCollection
    {
        $this->initiateSocialNetworkIfIsEmpty();
        return $this->socialNetwork;
    }

    private function initiateSocialNetworkIfIsEmpty() : void
    {
        if (empty($this->socialNetwork)) {
            $this->initiateSocialNetwork();
        }
    }

    public function updateCounter()
    {
        $newSocialNetwork = new SocialNetworkCollection();
        foreach ($this->socialNetwork() AS $socialNetwork) {
            $socialNetworkService = "App\\Domain\\Service\\" . $socialNetwork->name() . "Service";
            $newSocialNetwork->add(
                new SocialNetwork(
                    $socialNetwork->name(),
                    $socialNetworkService::getShares($this->url, !empty($this->lastUpdated)? $this->lastUpdated :(new \DateTimeImmutable()))
                )
            );
        }
        $this->overrideSocialNetwork($newSocialNetwork);
        $this->lastUpdated = new \DateTimeImmutable();
    }
}