<?php
namespace Covid\EventSourcing;

use Broadway\EventStore\InMemoryEventStore as BroadwayInMemoryEventStore;
use Broadway\EventStore\EventStore;
use Broadway\Domain\DomainEventStream;

class InMemoryEventStore implements EventStore
{

    private $store;

    public function __construct()
    {
        $this->store = new BroadwayInMemoryEventStore();
    }

    public function __call($method, $params)
    {
        return $this->store->$method(...$params);
    }

    public function load($id): DomainEventStream
    {
        $out = $this->store->load($id);

        return $out;
    }

    public function loadFromPlayhead($id, int $playhead): DomainEventStream
    {
        return $this->store->loadFromPlayhead($id, $playhead);
    }

    public function append($id, DomainEventStream $eventStream): void
    {
        $this->store->append($id, $eventStream);
    }

}
