<?php

namespace Crummy\Phlack\Bot\Mainframe;

use Crummy\Phlack\Common\Encodable;
use Crummy\Phlack\Common\Event;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Packet extends Event implements Encodable
{
    /**
     * @param array $options
     */
    public function __construct(array $options = [ ])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);

        parent::__construct($resolver->resolve($options));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired([ 'command' ]);
        $resolver->setDefaults([ 'output' => null ]);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this['output'] instanceof Encodable ? $this['output']->jsonSerialize() : $this['output'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }
}
