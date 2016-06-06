<?php

namespace Crummy\Phlack\Bridge\Symfony\HttpFoundation;

use Crummy\Phlack\WebHook\Command;
use Crummy\Phlack\WebHook\Converter\ConverterInterface;
use Symfony\Component\HttpFoundation\Request;

class RequestConverter implements ConverterInterface
{
    /**
     * @param Request $request
     *
     * @return Command
     */
    public function convert(Request $request)
    {
        return $this($request);
    }

    /**
     * @param Request $payload
     *
     * @return Command
     */
    public function __invoke($payload)
    {
        $parameters = $payload->request->all();

        if (empty($parameters) || !array_key_exists('command', $parameters)) {
            $parameters = $payload->query->all();
        }

        return new Command($parameters);
    }
}
