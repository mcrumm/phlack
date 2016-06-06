<?php

namespace Crummy\Phlack\WebHook\Converter;

interface ConverterInterface
{
    /**
     * Converts payload data into a Command.
     *
     * @param mixed $payload
     *
     * @throws \InvalidArgumentException
     *
     * @return \Crummy\Phlack\WebHook\Command
     */
    public function __invoke($payload);
}
