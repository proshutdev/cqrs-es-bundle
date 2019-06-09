<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/6/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Projection;
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
    public function init( array $data, string $fqcn ) {
        $CurrentUri     = strtok($this->request->getRequestUri(), '?');
        $this->type     = 'hydra:Collection';
        $this->resource = $fqcn::getResourceName();
        $this->context  = sprintf("/context/%s", $this->resource);
        $this->id       = $CurrentUri;
        $this->total    = $data[ 'total' ];
        foreach ($data[ 'hits' ] as $member) {
            $Object         = $this->denormalizer->denormalize($member, $fqcn, 'array');
            $this->member[] = [ "@id" => $Object->getUri($CurrentUri) ] + [ '@type' => $this->resource ] +
                $this->normalizer->normalize($Object, 'array', [ 'groups' => 'collection' ]);
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