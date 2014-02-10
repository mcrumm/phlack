<?php

namespace Crummy\Phlack\Common\Matcher;

interface MatcherAggregate
{
    /**
     * @return MatcherInterface
     */
    public function getMatcher();
}
