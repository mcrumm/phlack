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
        return $this($command);
    }

    /**
     * @param mixed $payload
     *
     * @return \Crummy\Phlack\WebHook\CommandInterface
     */
    public function __invoke($payload)
    {
        if (0 !== strpos($payload, '/')) {
            return new WebHook(['text' => $payload] + $this->webHook);
        } else {
            list($payload, $text) = explode(' ', $payload, 2);

            return new SlashCommand(['command' => $payload, 'text' => $text] + $this->slashCommand);
        }
    }
}
