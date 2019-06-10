<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/6/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\ReadModel;
/**
 * Interface ReadModelInterface
 * @package Proshut\CQRSBundle\ReadModel
 */
interface ReadModelInterface {

    /**
     * @return string
     */
    public function getId(): string;
}