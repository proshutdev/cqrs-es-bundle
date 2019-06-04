<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 5/31/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Normalizer;

use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Description of ApiExceptionNormalizer
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
final class ApiExceptionNormalizer implements NormalizerInterface {

    /**
     * @param mixed $object
     * @param null  $format
     * @param array $context
     *
     * @return array|bool|float|int|string
     */
    public function normalize( $object, $format = null, array $context = [] ) {
        /**
         * @var \Exception $object
         */
        $ClassNamespace = explode("\\", get_class($object->getPrevious() ?: $object));
        $Data           = [ '@context'          => '/contexts/Error',
                            '@type'             => end($ClassNamespace),
                            'hydra:title'       => 'An error occurred',
                            'hydra:description' => $object->getMessage() ];
        if ($_ENV[ 'APP_ENV' ] === 'dev') {
            $Data[ 'hydra:file' ] = $object->getFile();
            $Data[ 'hydra:line' ] = $object->getLine();
        }
        return $Data;
    }

    /**
     * @param mixed $data
     * @param null  $format
     *
     * @return bool
     */
    public function supportsNormalization( $data, $format = null ) {
        return $data instanceof \Exception;
    }
}