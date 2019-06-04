<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 4/16/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\ValueObject;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Guid
 * @package Proshut\CQRSBundle\ValueObject
 */
final class Guid implements ValueObjectInterface {

    /**
     * @var UuidInterface
     */
    private $uuid;

    /**
     * Guid constructor.
     *
     * @param UuidInterface $uuid
     */
    public function __construct( UuidInterface $uuid ) {
        $this->uuid = $uuid;
    }

    /**
     * @return Guid
     * @throws \Exception
     */
    public static function generate() {
        return new self(Uuid::uuid4());
    }

    /**
     * @param string $string
     *
     * @return Guid
     */
    public static function fromString( string $string ) {
        return new self(Uuid::fromString($string));
    }

    /**
     * @return string
     */
    public function toString(): string {
        return $this->uuid;
    }
}