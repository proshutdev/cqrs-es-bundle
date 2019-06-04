<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/1/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\ValueObject;
/**
 * Interface ArrayValueObjectInterface
 * @package Proshut\CQRSBundle\ValueObject
 */
interface ArrayValueObjectInterface extends ValueObjectInterface {

    /**
     * @param array $array
     *
     * @return mixed
     */
    public static function fromArray( array $array );

    /**
     * @return array
     */
    public function toArray(): array;
}