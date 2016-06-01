<?php

namespace Crummy\Phlack\Bridge\Guzzle\Response;

use Guzzle\Common\Collection;
use Guzzle\Service\Command\OperationCommand;
use Guzzle\Service\Command\ResponseClassInterface;

class MessageResponse extends Collection implements ResponseClassInterface
{
    /**
     * @see ResponseClassInterface
     */
    public static function fromCommand(OperationCommand $command)
    {
        $response = $command->getResponse();

        return new self([
            'status' => $response->getStatusCode(),
            'reason' => $response->getReasonPhrase(),
            'text'   => $response->getBody(true),
        ]);
    }
}
