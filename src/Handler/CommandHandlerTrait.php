<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/2/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Handler;

use Proshut\CQRSBundle\Event\EventRecorderInterface;
use Proshut\CQRSBundle\Infrastructure\EventStore\DocumentEventStore;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Trait CommandHandlerTrait
 * @package Proshut\CQRSBundle\Handler
 */
trait CommandHandlerTrait {

    /**
     * @var DocumentEventStore
     */
    private $eventStore;
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * CommandHandlerTrait constructor.
     *
     * @param DocumentEventStore  $eventStore
     * @param MessageBusInterface $eventBus
     */
    public function __construct(
        DocumentEventStore $eventStore, MessageBusInterface $eventBus ) {
        $this->eventStore = $eventStore;
        $this->eventBus   = $eventBus;
    }

    /**
     * @param EventRecorderInterface $aggregateRoot
     */
    private function dispatchEvents( EventRecorderInterface $aggregateRoot ) {
        foreach ($aggregateRoot->getRecordedEvents() as $event) {
            usleep(100);
            $this->eventBus->dispatch($event);
        }
    }
}