<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/5/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Projection;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Description of CollectionViewNormalizer
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class CollectionViewNormalizer implements NormalizerInterface {

    private $normalizer;
    private $request;

    public function __construct( ObjectNormalizer $normalizer, RequestStack $requestStack ) {
        $this->normalizer = $normalizer;
        $this->request    = $requestStack->getCurrentRequest();
    }

    /**
     * @param mixed $object
     * @param null  $format
     * @param array $context
     *
     * @return array|bool|float|int|string
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize( $object, $format = null, array $context = [] ) {
        /**
         * @var CollectionView $object
         */
        $Data[ '@context' ]     = $object->getContext();
        $Data[ '@type' ]        = $object->getType();
        $Data[ '@id' ]          = $object->getId();
        $Data[ 'hydra:total' ]  = $object->getTotal();
        $Data[ 'hydra:member' ] = $object->getMember();
        return $Data;
    }

    /**
     * @param mixed $data
     * @param null  $format
     *
     * @return bool
     */
    public function supportsNormalization( $data, $format = null ) {
        return $data instanceof CollectionView;
    }
}