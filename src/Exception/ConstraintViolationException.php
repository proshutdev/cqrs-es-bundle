<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 5/31/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Exception;

use Assert\InvalidArgumentException;

/**
 * Description of ConstraintViolationException
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class ConstraintViolationException extends \LogicException {

    public function __construct( InvalidArgumentException $message ) {
        parent::__construct(sprintf("%s: %s", $message->getPropertyPath(), $message->getMessage()));
    }
}