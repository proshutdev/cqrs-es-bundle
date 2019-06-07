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
    private $request;
    private $context;
    private $id;
    private $type;

    public function __construct( DenormalizerInterface $denormalizer, RequestStack $requestStack, NormalizerInterface $normalizer ) {
        $this->denormalizer = $denormalizer;
        $this->normalizer   = $normalizer;
        $this->request      = $requestStack->getCurrentRequest();
    }

    private static function transformFromElasticIndex( array $data ) {
        return array_merge([ 'id' => $data[ '_id' ] ], $data[ '_source' ]);
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
}