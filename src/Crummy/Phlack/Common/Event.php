<?php

namespace Crummy\Phlack\Common;

use Guzzle\Common\Event as GuzzleEvent;

class Event extends GuzzleEvent
{
    /**
     * {@inheritdoc}
     */
    public function __construct(array $context = [])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);

        parent::__construct($resolver->resolve($context));
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        // noop
    }
}
