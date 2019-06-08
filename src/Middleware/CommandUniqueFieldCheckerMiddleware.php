<?php
/*
* This file is part of the Proshut application project
* (c) Proshut Web Development Company <info@proshut.biz> | 6/4/19
* For the full copyright and license information, please view the LICENSE
*/

namespace Proshut\CQRSBundle\Middleware;

use Proshut\CQRSBundle\Command\CommandHasUniqueField;
use Proshut\CQRSBundle\Command\CommandInterface;
use Proshut\CQRSBundle\Service\DomainUniqueFieldService;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Symfony\Component\Messenger\Stamp\BusNameStamp;

/**
 * Description of CommandUniqueFieldCheckerMiddleware
 *
 * @author Proshut Web Development <info at proshut.biz>
 */
final class CommandUniqueFieldCheckerMiddleware implements MiddlewareInterface {

    private $uniqueFieldService;

    public function handle( Envelope $envelope, StackInterface $stack ): Envelope {
        if ($envelope->last(BusNameStamp::class) && $envelope->getMessage() instanceof CommandHasUniqueField) {
            $Command = $envelope->getMessage();
            /**
             * @var CommandInterface $Command
             */
            $this->uniqueFieldService->setCommand($Command)->check();
            $envelope = $stack->next()->handle($envelope, $stack);
            $this->uniqueFieldService->setCommand($Command)->save();
            return $envelope;
        }
        return $stack->next()->handle($envelope, $stack);
    }

    public function __construct( DomainUniqueFieldService $uniqueFieldService ) {
        $this->uniqueFieldService = $uniqueFieldService;
    }
}