<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/1/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\ValueObject;
/**
 * Interface StringValueObjectInterface
 * @package Proshut\CQRSBundle\ValueObject
 */
interface StringValueObjectInterface extends ValueObjectInterface {

    /**
     * @param string $string
     *
     * @return mixed
     */
    public static function fromString( string $string );

    /**
     * @return string
     */
    public function toString(): string;
}