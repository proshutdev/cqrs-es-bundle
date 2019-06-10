<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/7/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\ReadModel;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Trait ViewTrait
 * @package Proshut\CQRSBundle\ReadModel
 */
trait ViewTrait {

    /**
     * @var DenormalizerInterface
     */
    private $denormalizer;
    /**
     * @var NormalizerInterface
     */
    private $normalizer;
    /**
     * @var string
     */
    private $resource;
    /**
     * @var string
     */
    private $context;
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $type;
    /**
     * @var string
     */
    private $requestUri;
    /**
     * @var string
     */
    private $group = null;

    /**
     * ViewTrait constructor.
     *
     * @param DenormalizerInterface $denormalizer
     * @param RequestStack          $requestStack
     * @param NormalizerInterface   $normalizer
     */
    public function __construct( DenormalizerInterface $denormalizer, RequestStack $requestStack, NormalizerInterface $normalizer ) {
        $this->denormalizer = $denormalizer;
        $this->normalizer   = $normalizer;
        $this->requestUri   = strtok($requestStack->getCurrentRequest()->getRequestUri(), '?');
    }

    /**
     * @param string $fcqn
     *
     * @return mixed
     */
    private static function getResourceName( string $fcqn ) {
        $ClassParts = explode("\\", $fcqn);
        return end($ClassParts);
    }

    /**
     * @param string $fqcn
     *
     * @return bool
     */
    private function isReadModel( string $fqcn ) {
        return in_array(ReadModelInterface::class, class_implements($fqcn));
    }

    /**
     * @return DenormalizerInterface
     */
    public function getDenormalizer(): DenormalizerInterface {
        return $this->denormalizer;
    }

    /**
     * @return NormalizerInterface
     */
    public function getNormalizer(): NormalizerInterface {
        return $this->normalizer;
    }

    /**
     * @return string
     */
    public function getResource(): string {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getContext(): string {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getRequestUri(): string {
        return $this->requestUri;
    }

    /**
     * @return string
     */
    public function getGroup(): string {
        return $this->group;
    }

    /**
     * @param string $group
     */
    public function setGroup( string $group ): void {
        $this->group = $group;
        return $this;
    }
}