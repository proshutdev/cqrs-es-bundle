<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/2/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Event;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializer;

/**
 * Class DomainEventMessengerTransportSerializer
 * @package Proshut\CQRSBundle\Event
 */
final class DomainEventMessengerTransportSerializer implements SerializerInterface {

    private $serializer;

    public function __construct( SymfonySerializer $serializer ) {
        $this->serializer = $serializer;
    }

    /**
     * @param array $encodedEnvelope
     *
     * @return Envelope
     */
    public function decode( array $encodedEnvelope ): Envelope {
        /**
         * @var DomainEventInterface $Message
         */
        $Message   = $encodedEnvelope[ 'headers' ][ 'event' ]::deserialize(json_decode($encodedEnvelope[ 'body' ], true),
                                                                           $encodedEnvelope[ 'headers' ][ 'aggregateId' ]);
        $BusStamp  = new BusNameStamp($encodedEnvelope[ 'headers' ][ 'stamps' ][ BusNameStamp::class ]);
        $SentStamp = new SentStamp($encodedEnvelope[ 'headers' ][ 'stamps' ][ SentStamp::class ][ 'senderClass' ],
                                   $encodedEnvelope[ 'headers' ][ 'stamps' ][ SentStamp::class ][ 'senderAlias' ]);
        $Envelop   = new Envelope($Message->withVersion($encodedEnvelope[ 'headers' ][ 'version' ]), [ $BusStamp,
                                                                                                       $SentStamp ]);
        return $Envelop;
    }

    /**
     * @param Envelope $envelope
     *
     * @return array
     */
    public function encode( Envelope $envelope ): array {
        $Message                       = $envelope->getMessage();
        $Stamps[ BusNameStamp::class ] = $envelope->last(BusNameStamp::class)->getBusName();
        $Stamps[ SentStamp::class ]    = [ 'senderClass' => $envelope->last(SentStamp::class)->getSenderClass(),
                                           'senderAlias' => $envelope->last(SentStamp::class)->getSenderAlias() ];
        /**
         * @var DomainEventInterface $Message
         */
        $Encode[ 'headers' ] = [ 'event'       => get_class($Message),
                                 'version'     => $Message->getVersion(),
                                 'aggregateId' => $Message->getAggregateId(),
                                 'stamps'      => $Stamps ];
        $Encode[ 'body' ]    = json_encode($Message->serialize());
        return $Encode;
    }
}