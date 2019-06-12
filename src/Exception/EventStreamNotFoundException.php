<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/12/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Description of EventStreamNotFoundException
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
final class EventStreamNotFoundException extends NotFoundHttpException {

}