<?php

namespace Crummy\Phlack\WebHook\Converter;

use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHook;

class StringConverter implements ConverterInterface
{
    protected $webHook = [
        'token'        => '',
        'team_id'      => '',
        'team_domain'  => '',
        'service_id'   => '',
        'channel_id'   => '',
        'channel_name' => '',
        'timestamp'    => 0.000000,
        'user_id'      => '',
        'user_name'    => '',
    ];

    protected $slashCommand = [
        'token'        => '',
        'team_id'      => '',
        'channel_id'   => '',
        'channel_name' => '',
        'user_id'      => '',
        'user_name'    => '',
    ];

    /**
     * @param $command
     *
     * @return \Crummy\Phlack\WebHook\CommandInterface
     */
    public function convert($command)
    {
        if (0 !== strpos($command, '/')) {
            return new WebHook(['text' => $command] + $this->webHook);
        } else {
            list($command, $text) = explode(' ', $command, 2);

            return new SlashCommand(['command' => $command, 'text' => $text] + $this->slashCommand);
        }
    }
}
