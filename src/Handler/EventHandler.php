<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 5/12/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Handler;

use Proshut\CQRSBundle\Event\DomainEventInterface;
use Proshut\CQRSBundle\Exception\InvalidProjectionException;
use Proshut\CQRSBundle\Projection\ReadModelProjectorInterface;
use Psr\Container\ContainerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Description of EventHandler
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
final class EventHandler implements MessageHandlerInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param DomainEventInterface $event
     */
    public function __invoke( DomainEventInterface $event ) {
        if (!$Projection = $event->getProjection()) {
            throw new InvalidProjectionException('error.global.projection.blank');
        }
        if (false === class_exists($Projection)) {
            throw new InvalidProjectionException('error.global.projection.notFound');
        }
        $ProjectionInstance = $this->container->get($Projection);
        if (!$ProjectionInstance instanceof ReadModelProjectorInterface) {
            throw new InvalidProjectionException('error.global.projection.notFound');
        }
        $ClassParts = explode("\\", get_class($event));
        $MethodName = sprintf("apply%s", ucfirst(end($ClassParts)));
        if (!method_exists($ProjectionInstance, $MethodName)) {
            throw new InvalidProjectionException("error.global.projection.methodNotFound");
        }
        $ProjectionInstance->$MethodName($event);
    }

    /**
     * EventHandler constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct( ContainerInterface $container ) {
        $this->container = $container;
    }
}