<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/6/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\ReadModel;
/**
 * Description of CollectionReadModel
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class CollectionView {

    use ViewTrait;
    /**
     * @var int
     */
    private $total = 0;
    /**
     * @var array
     */
    private $member = [];

    /**
     * @param array  $data
     * @param string $fqcn
     *
     * @return $this
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function create( array $data, string $fqcn ) {
        if (false === $this->isReadModel($fqcn)) {
            throw new \InvalidArgumentException('error.global.readmodel.notImplemented');
        }
        $this->type     = 'hydra:Collection';
        $this->resource = static::getResourceName($fqcn);
        $this->context  = sprintf("/context/%s", $this->resource);
        $this->id       = $this->requestUri;
        $this->total    = $data[ 'total' ];
        foreach ($data[ 'hits' ] as $member) {
            $Object         = $this->denormalizer->denormalize($member, $fqcn, 'array');
            $this->member[] = [ "@id" => sprintf("%s/%s", $this->requestUri, $Object->getId()) ] + [ '@type' => $this->resource ] +
                $this->normalizer->normalize($Object, 'array', [ 'group' => $this->getGroup() ?: sprintf("%s_collection", strtolower($this->resource))  ]);
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getTotal(): int {
        return $this->total;
    }

    /**
     * @return array
     */
    public function getMember(): array {
        return $this->member;
    }
}