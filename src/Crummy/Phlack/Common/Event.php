<?php

namespace Crummy\Phlack\Common;

use Guzzle\Common\Event as GuzzleEvent;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Event extends GuzzleEvent
{
    /**
     * {@inheritDoc}
     */
    public function __construct(array $context = [ ])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);

        parent::__construct($resolver->resolve($context));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // noop
    }
}