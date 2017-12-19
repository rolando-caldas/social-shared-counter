<?php

namespace App\Domain;

trait TriggerEventsTrait
{
    protected function trigger($event)
    {
        DomainEventPublisher::instance()->publish($event);
    }
}