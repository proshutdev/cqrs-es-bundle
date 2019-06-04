<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/1/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Event;
/**
 * Trait EventRecorderTrait
 * @package Proshut\CQRSBundle\Event
 */
trait EventRecorderTrait {

    /**
     * @var array
     */
    private $events = [];
    /**
     * @var int
     */
    private $version = 0;

    /**
     * @param DomainEventInterface $event
     */
    private function recordThat( DomainEventInterface $event ) {
        $this->version++;
        $this->events[] = $event->withVersion($this->version);
        $this->apply($event);
    }

    /**
     * @param DomainEventInterface $event
     */
    public function apply( DomainEventInterface $event ) {
        $ClassParts = explode("\\", get_class($event));
        $MethodName = 'apply' . end($ClassParts);
        if (method_exists($this, $MethodName)) {
            $this->$MethodName($event);
        }
    }

    /**
     * @return array
     */
    public function getRecordedEvents(): array {
        return $this->events;
    }

    public function clearRecordedEvents() {
        $this->events = [];
    }

    /**
     * @param \Iterator $historyEvents
     *
     * @return EventRecorderTrait
     */
    public static function reconstituteFromHistory( \Iterator $historyEvents ): self {
        $instance = new static();
        $instance->replay($historyEvents);
        return $instance;
    }

    /**
     * @param \Iterator $historyEvents
     */
    private function replay( \Iterator $historyEvents ): void {
        foreach ($historyEvents as $pastEvent) {
            $this->version = $pastEvent->getVersion();
            $this->apply($pastEvent);
        }
    }
}