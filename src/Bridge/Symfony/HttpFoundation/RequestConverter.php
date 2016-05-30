<?php

namespace Crummy\Phlack\Bridge\Symfony\HttpFoundation;

use Crummy\Phlack\Common\Exception\UnexpectedValueException;
use Crummy\Phlack\WebHook\Converter\ConverterInterface;
use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHook;
use Guzzle\Service\Command\CommandInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestConverter implements ConverterInterface
{
    public function convert(Request $request)
    {
        return $this($request);
    }

    /**
     * @param Request $payload
     * @return CommandInterface
     */
    public function __invoke($payload)
    {
        try {
            $parameters = $payload->request->all();

            if (array_key_exists('command', $parameters)) {
                return new SlashCommand($parameters);
            } elseif (empty($parameters)) {
                $parameters = $payload->query->all();
            }

            return new WebHook($parameters);
        } catch (\Exception $exception) {
            throw new UnexpectedValueException('Request could not be converted.', 0, $exception);
        }
    }
}
