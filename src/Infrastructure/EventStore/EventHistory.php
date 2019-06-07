<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/7/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Infrastructure\EventStore;
/**
 * Description of EventHistory
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class EventHistory extends \ArrayIterator {

    public static function with( array $array ) {
        return new self($array);
    }
}