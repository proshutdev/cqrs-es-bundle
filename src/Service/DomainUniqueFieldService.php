<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/3/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Service;

use Proshut\CQRSBundle\Command\CommandInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Description of DomainUniqueFieldService
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
final class DomainUniqueFieldService {

    /**
     * @var \Redis
     */
    private $redis;
    /**
     * @var NormalizerInterface
     */
    private $normalizer;
    /**
     * @var array
     */
    private $fields = [];
    /**
     * @var
     */
    private $command;
    /**
     * @var
     */
    private $prefix;

    /**
     * DomainUniqueFieldService constructor.
     *
     * @param \Redis              $redis
     * @param NormalizerInterface $normalizer
     */
    public function __construct( \Redis $redis, NormalizerInterface $normalizer ) {
        $this->redis      = $redis;
        $this->normalizer = $normalizer;
    }

    /**
     * @param CommandInterface $command
     *
     * @return $this
     */
    public function setCommand( CommandInterface $command ) {
        $this->command = $command;
        $ClassParts    = explode("\\", get_class($command));
        $this->prefix  = strtolower(end($ClassParts));
        return $this;
    }

    /**
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    private function setFields() {
        $this->fields = $this->normalizer->normalize($this->command, 'array', [ 'groups' => 'unique' ]);
    }

    /**
     * @return null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function save() {
        if (!$this->command) {
            return null;
        }
        $this->setFields();
        if (!$this->fields) {
            return null;
        }
        foreach ($this->fields as $field => $value) {
            $this->redis->sAdd(sprintf("%s:%s", $this->prefix, strtolower($field)), strtolower($value));
        }
    }

    /**
     * @return null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function check() {
        if (!$this->command) {
            return null;
        }
        $this->setFields();
        if (!$this->fields) {
            return null;
        }
        foreach ($this->fields as $field => $value) {
            if ($this->redis->sIsMember(sprintf("%s:%s", $this->prefix, strtolower($field)), strtolower($value))) {
                throw new \InvalidArgumentException(sprintf("error.%s.%s.duplicate", $this->prefix, $field));
            }
        }
    }
}