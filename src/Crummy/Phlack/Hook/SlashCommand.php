<?php

namespace Crummy\Phlack\Hook;

use Crummy\Phlack\Hook\Exception\ValidationException;
use Guzzle\Common\Exception\InvalidArgumentException;

class SlashCommand extends Hook
{
    /**
     * @param boolean $useGet
     * @return SlashCommand
     * @throws Exception\ValidationException
     */
    static public function createFromGlobal($useGet = null)
    {
        try {
            $collection = self::fromConfig((boolean)$useGet ? $_GET : $_POST, [ ], self::getRequiredFields());
            return new self($collection->toArray());
        } catch (InvalidArgumentException $missingFields) {
            throw new ValidationException(str_replace('Config', 'SlashCommand', $missingFields->getMessage()));
        }
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
            'user_id',
            'user_name',
            'command',
            'text'
        ];
    }
}
