<?php

namespace Crummy\Phlack\WebHook\Matcher;

interface MatcherAggregate
{
    /**
     * @return MatcherInterface
     */
    public function getMatcher();
}
