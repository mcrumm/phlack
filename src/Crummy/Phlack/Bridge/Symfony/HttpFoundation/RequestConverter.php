<?php

namespace Crummy\Phlack\Bridge\Symfony\HttpFoundation;

use Crummy\Phlack\Common\Exception\UnexpectedValueException;
use Crummy\Phlack\WebHook\Converter\ConverterInterface;
use Crummy\Phlack\WebHook\SlashCommand;
use Crummy\Phlack\WebHook\WebHook;
use Symfony\Component\HttpFoundation\Request;

class RequestConverter implements ConverterInterface
{
    public function convert(Request $request)
    {
        try {
            $parameters = $request->request->all();

            if (array_key_exists('command', $parameters)) {
                return new SlashCommand($parameters);
            } elseif (empty($parameters)) {
                $parameters = $request->query->all();
            }

            return new WebHook($parameters);
        } catch (\Exception $exception) {
            throw new UnexpectedValueException('Request could not be converted.', 0, $exception);
        }
    }
}
