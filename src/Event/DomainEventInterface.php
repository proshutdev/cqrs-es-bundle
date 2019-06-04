<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/1/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Event;
/**
 * Interface DomainEventInterface
 * @package Proshut\CQRSBundle\Event
 */
interface DomainEventInterface {

    /**
     * @return string
     */
    public function getAggregateId(): string;

    /**
     * @return string
     */
    public function getProjection(): string;

    /**
     * @param $version
     *
     * @return mixed
     */
    public function withVersion( $version );

    /**
     * @return int
     */
    public function getVersion(): int;

    /**
     * @return array
     */
    public function serialize(): array;

    /**
     * @param array  $data
     * @param string $id
     *
     * @return mixed
     */
    public static function deserialize( array $data, string $id );
}