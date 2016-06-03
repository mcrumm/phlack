<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\WebHook\Matcher\MatcherInterface;

interface MainframeInterface extends Executable
{
    /**
     * @param Executable                     $assistant Something that can respond to the incoming Command.
     * @param MatcherInterface|callable|null $matcher   Determines whether or not the assistant will respond.
     *
     * @return void
     */
    public function attach(Executable $assistant, $matcher = null);
}
