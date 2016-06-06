<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\WebHook\Matcher\MatcherInterface;

interface MainframeInterface extends Executable
{
    /**
     * Attaches an assistant to the mainframe that can respond to commands.
     *
     * If $matcher is provided as a `callable`, it should accept a Command and return a boolean.
     *
     * @param Executable                     $assistant Something that can respond to the incoming Command.
     * @param MatcherInterface|callable|null $matcher   Determines whether or not the assistant will respond.
     *
     * @return void
     */
    public function attach(Executable $assistant, $matcher = null);
}
