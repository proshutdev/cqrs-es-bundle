<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/6/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Normalizer;

use Proshut\CQRSBundle\ReadModel\ItemView;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Description of ItemViewNormalizer
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class ItemViewNormalizer implements NormalizerInterface {

    private $normalizer;
    private $request;

    public function __construct( ObjectNormalizer $normalizer, RequestStack $requestStack ) {
        $this->normalizer = $normalizer;
        $this->request    = $requestStack->getCurrentRequest();
    }

    public function normalize( $object, $format = null, array $context = [] ) {
        /**
         * @var ItemView $object
         */
        $Data[ '@context' ] = $object->getContext();
        $Data[ '@type' ]    = $object->getType();
        $Data[ '@id' ]      = $object->getId();
        $Response           = $object->getItem() ? $Data + $this->normalizer->normalize($object->getItem(), 'array',
                                                                                        [ 'group' => $object->getGroup() ?:
                                                                                            sprintf("%s_item",
                                                                                                    strtolower($object->getResource())) ]) :
            null;
        return $Response;
    }

    public function supportsNormalization( $data, $format = null ) {
        return $data instanceof ItemView;
    }
}