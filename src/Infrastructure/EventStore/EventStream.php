<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 5/12/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Infrastructure\EventStore;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * Description of EventStream
 *
 * @author Proshut Web Development <info at proshut.biz>
 * @MongoDB\Document()
 */
class EventStream {

    /**
     * @var string
     * @MongoDB\Id()
     */
    private $id;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $guid;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $event;
    /**
     * @var string
     * @MongoDB\Field(type="string")
     */
    private $payload;
    /**
     * @var \DateTimeImmutable
     * @MongoDB\Field(type="date")
     */
    private $created;
    /**
     * @var int
     * @MongoDB\Field(type="integer")
     */
    private $version;

    public function __construct() {
        $this->created = new \DateTimeImmutable();
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return EventStream
     */
    public function setId( string $id ): EventStream {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getEvent(): string {
        return $this->event;
    }

    /**
     * @param string $event
     *
     * @return EventStream
     */
    public function setEvent( string $event ): EventStream {
        $this->event = $event;
        return $this;
    }

    /**
     * @return string
     */
    public function getPayload(): string {
        return $this->payload;
    }

    /**
     * @param string $payload
     *
     * @return EventStream
     */
    public function setPayload( string $payload ): EventStream {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreated(): \DateTimeImmutable {
        return $this->created;
    }

    /**
     * @param \DateTimeImmutable $created
     *
     * @return EventStream
     */
    public function setCreated( \DateTimeImmutable $created ): EventStream {
        $this->created = $created;
        return $this;
    }

    /**
     * @return string
     */
    public function getGuid(): string {
        return $this->guid;
    }

    /**
     * @param string $guid
     *
     * @return EventStream
     */
    public function setGuid( string $guid ): EventStream {
        $this->guid = $guid;
        return $this;
    }

    /**
     * @return int
     */
    public function getVersion(): int {
        return $this->version;
    }

    /**
     * @param int $version
     *
     * @return EventStream
     */
    public function setVersion( int $version ): EventStream {
        $this->version = $version;
        return $this;
    }
}