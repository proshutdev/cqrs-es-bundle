<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/1/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Aggregate;

use Proshut\CQRSBundle\Event\DomainEventInterface;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Trait AggregateChangedTrait
 * @package Proshut\CQRSBundle\Aggregate
 */
trait AggregateChangedTrait {

    /**
     * @var string
     * @Groups({"serializable"})
     */
    private $aggregateId;
    /**
     * @var int
     */
    private $version = 0;

    /**
     * @param string $id
     * @param array  $payload
     *
     * @return AggregateChangedTrait
     */
    protected static function occur( string $id, array $payload ): self {
        $Static              = new static();
        $Static->aggregateId = $id;
        foreach ($payload as $Prop => $Value) {
            $Static->$Prop = $Value;
        }
        return $Static;
    }

    /**
     * @param $version
     *
     * @return AggregateChangedTrait
     */
    public function withVersion( $version ): self {
        $this->version = $version;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAggregateId(): string {
        return $this->aggregateId;
    }

    /**
     * @param string $aggregateId
     *
     * @return DomainEventInterface
     */
    public function setAggregateId( string $aggregateId ):self {
        $this->aggregateId = $aggregateId;
        return $this;
    }

    /**
     * @return int
     */
    public function getVersion(): int {
        return $this->version;
    }
}