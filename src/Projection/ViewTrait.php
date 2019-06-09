<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/7/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Projection;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

trait ViewTrait {

    private $denormalizer;
    private $normalizer;
    private $resource;
    private $context;
    private $id;
    private $type;
    private $requestUri;

    public function __construct( DenormalizerInterface $denormalizer, RequestStack $requestStack, NormalizerInterface $normalizer ) {
        $this->denormalizer = $denormalizer;
        $this->normalizer   = $normalizer;
        $this->requestUri   = strtok($requestStack->getCurrentRequest()->getRequestUri(), '?');
    }

    /**
     * @return mixed
     */
    public function getContext() {
        return $this->context;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getResource() {
        return $this->resource;
    }

    private static function getResourceName( string $fcqn ) {
        $ClassParts = explode("\\", $fcqn);
        return end($ClassParts);
    }
}