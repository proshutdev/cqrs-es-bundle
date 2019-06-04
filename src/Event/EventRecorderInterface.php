<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/1/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Event;
/**
 * Interface EventRecorderInterface
 * @package Proshut\CQRSBundle\Event
 */
interface EventRecorderInterface {

    /**
     * @return array
     */
    public function getRecordedEvents(): array;

    public function clearRecordedEvents();

    /**
     * @param DomainEventInterface $event
     *
     * @return mixed
     */
    public function apply( DomainEventInterface $event );
}