<?php

namespace Crummy\Phlack\Bot;

use Crummy\Phlack\Common\Responder\ResponderInterface;

interface ResponderAware extends BotInterface
{
    /**
     * @param ResponderInterface $responder
     * @return self
     */
    public function setResponder(ResponderInterface $responder);
}
