<?php

namespace Crummy\Phlack\Bot\Mainframe;

use Crummy\Phlack\Common\Encodable;
use Crummy\Phlack\Common\Event;
use Crummy\Phlack\Common\OptionsResolver;

class Packet extends Event implements Encodable
{
    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);

        parent::__construct($resolver->resolve($options));
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(['command']);
        $resolver->setDefaults(['output' => null]);

        $resolver->setTypesAllowed([
            'command' => '\Crummy\Phlack\WebHook\CommandInterface',
            'output'  => ['\Crummy\Phlack\WebHook\Reply\Reply', 'null'],
        ]);
    }

    /**
     * {@inheritdoc}
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
