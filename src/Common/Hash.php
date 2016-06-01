<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\Common\Exception\LogicException;
use Guzzle\Common\Collection as GuzzleCollection;

class Hash extends GuzzleCollection implements Encodable
{
    protected $required = [];
    protected $defaults = [];
    protected $optional = [];

    /**
     * @param array $data
     */
    public function __construct($data = [])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);
        parent::__construct($resolver->resolve($data));
    }

    /**
     * {@inheritdoc}
     */
    public static function fromConfig(array $config = [], array $defaults = [], array $required = [])
    {
        if (!empty($defaults) || !empty($required)) {
            throw new LogicException('Setting options on fromConfig is not allowed.');
        }

        return new static($config);
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired($this->required);
        $resolver->setDefined($this->optional);
        $resolver->setDefaults($this->defaults);
    }
}
