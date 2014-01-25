<?php

namespace Crummy\Phlack\Hook;

use Crummy\Phlack\Hook\Exception\ValidationException;
use Guzzle\Common\Collection;
use Guzzle\Common\Exception\InvalidArgumentException;

class Hook extends Collection implements HookInterface
{
    /**
     * @return Hook
     * @throws Exception\ValidationException
     */
    static public function createFromGlobal()
    {
        try {
            $collection = self::fromConfig($_POST, [ ], self::getRequiredFields());
            return new self($collection->toArray());
        } catch (InvalidArgumentException $missingFields) {
            throw new ValidationException(str_replace('Config', 'Hook', $missingFields->getMessage()));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @see HookInterface::getRequiredFields
     */
    static public function getRequiredFields()
    {
        return [
            'token',
            'team_id',
            'channel_id',
            'channel_name',
            'timestamp',
            'user_id',
            'user_name',
            'text'
        ];
    }
}
