<?php

namespace App\Domain;

class DomainEventPublisher
{

    private $subscribers;
    private static $instance = null;

    public static function instance() : DomainEventPublisher
    {
        if (static::$instance === null) {
            static::$instance = new self();
        }

        return static::$instance;
    }

    private function __construct()
    {
        $this->subscribers = [];
    }

    public function subscribe(DomainEventSubscriber $domainEventSubscriber)
    {
        $id = $this->id;
        $this->subscribers[$id] = $domainEventSubscriber;
        $this->id++;

        return $id;
    }

    public function unsubscribe(int $id)
    {
        if (!array_key_exists($id, $this->subscribers)) {
            throw new \Exception($id . ' is not subscribed');
        }

        unset ($this->subscribers[$id]);
    }

    public function publish(DomainEvent $domainEvent)
    {
        foreach ($this->subscribers AS $subscriber) {
            if ($subscriber->isSubscribedTo($domainEvent)) {
                $subscriber->handle($domainEvent);
            }
        }
    }

}