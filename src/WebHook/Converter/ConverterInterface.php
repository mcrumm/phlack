<?php

namespace Crummy\Phlack\WebHook\Converter;

interface ConverterInterface
{
    /**
     * Converts payload data into a CommandInterface.
     *
     * @param mixed $payload
     *
     * @throws \InvalidArgumentException
     *
     * @return \Crummy\Phlack\WebHook\CommandInterface
     */
    public function __invoke($payload);
}
