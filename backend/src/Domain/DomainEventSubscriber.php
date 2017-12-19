<?php

namespace App\Domain;

interface DomainEventSubscriber
{
    public function handle($domainEvent) : bool;
    public function isSubscribedTo($domainEvent) : bool;
}