<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/2/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Infrastructure\EventStore;

use Doctrine\ODM\MongoDB\DocumentManager;
use Proshut\CQRSBundle\Event\DomainEventInterface;
use Proshut\CQRSBundle\Event\EventRecorderInterface;
use Proshut\CQRSBundle\Exception\EventStorePersistenceException;
use Proshut\CQRSBundle\Exception\EventStreamNotFoundException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Description of DocumentEventStore
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
final class DocumentEventStore {

    private $documentManager;
    private $serializer;

    public function __construct( DocumentManager $documentManager, SerializerInterface $serializer ) {
        $this->documentManager = $documentManager;
        $this->serializer      = $serializer;
    }

    public function save( EventRecorderInterface $aggregateRoot ) {
        $EventStreams = $aggregateRoot->getRecordedEvents();
        foreach ($EventStreams as $eventStream) {
            /**
             * @var DomainEventInterface $eventStream
             */
            $Row = new EventStream();
            $Row->setGuid($eventStream->getAggregateId())
                ->setCreated(new \DateTimeImmutable())
                ->setVersion($eventStream->getVersion())
                ->setEvent(get_class($eventStream))
                ->setPayload(json_encode($eventStream->serialize()));
            $this->documentManager->persist($Row);
        }
        try {
            $this->documentManager->flush();
        } catch (\Exception $e) {
            throw new EventStorePersistenceException($e->getMessage());
        }
    }

    public function load( string $id ) {
        $Events       = [];
        $EventStreams = $this->documentManager->getRepository(EventStream::class)->findBy([ 'guid' => $id ]);
        if (!$EventStreams) {
            throw new EventStreamNotFoundException('error.global.eventstream.invalidGuid');
        }
        foreach ($EventStreams as $eventStream) {
            /**
             * @var DomainEventInterface $Event
             */
            $Event = $eventStream->getEvent()::deserialize(json_decode($eventStream->getPayload(), true), $eventStream->getGuid());
            $Event->withVersion($eventStream->getVersion());
            $Events[] = $Event;
        }
        return EventHistory::with($Events);
    }
}