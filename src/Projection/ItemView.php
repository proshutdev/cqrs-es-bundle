<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/6/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Projection;
/**
 * Description of ItemReadModel
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
class ItemView {

    use ViewTrait;
    /**
     * @var
     */
    private $item;

    /**
     * @param array  $data
     * @param string $fqcn
     *
     * @return $this
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function init( array $data, string $fqcn ) {
        $this->resource = $this->type = $fqcn::getResourceName();
        $this->context  = sprintf("/context/%s", $this->resource);
        $this->id       = $this->request->getRequestUri();
        $this->item     = $this->denormalizer->denormalize(static::transformFromElasticIndex($data), $fqcn, 'array');
        return $this;
    }

    /**
     * @return mixed
     */
    public function getItem() {
        return $this->item;
    }

    /**
     * @param mixed $item
     *
     * @return ItemView
     */
    public function setItem( $item ) {
        $this->item = $item;
        return $this;
    }
}