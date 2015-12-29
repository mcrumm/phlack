<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Hash;

class AbstractCommand extends Hash implements CommandInterface
{
    protected $required = [
        'token',
        'team_id',
        'channel_id',
        'channel_name',
        'user_id',
        'user_name',
        'command',
        'text',
    ];
}
