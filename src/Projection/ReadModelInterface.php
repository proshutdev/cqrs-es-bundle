<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/6/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Projection;
interface ReadModelInterface {

    public function getUri( string $route ): string;

    public static function getResourceName(): string;

    public function getId(): string;
}