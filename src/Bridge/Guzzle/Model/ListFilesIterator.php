<?php

namespace Crummy\Phlack\Bridge\Guzzle\Model;

use Guzzle\Service\Resource\ResourceIterator;

class ListFilesIterator extends ResourceIterator
{
    /**
     * Send a request to retrieve the next page of results. Hook for subclasses to implement.
     *
     * @return array Returns the newly loaded resources
     */
    protected function sendRequest()
    {
        if ($this->nextToken) {
            $this->command->set('page', $this->nextToken);
        }

        $result = $this->command->execute();
        $currentToken = $result['paging']['page'];
        $this->nextToken = $result['paging']['pages'] > $currentToken ? ++$currentToken : false;

        return $result['files'];
    }
}
