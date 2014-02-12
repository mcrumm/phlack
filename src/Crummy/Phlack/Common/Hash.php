<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\Common\Exception\RuntimeException;
use Guzzle\Common\Collection as GuzzleCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

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
     * {@inheritDoc}
     * @throws RuntimeException if a parameter is missing
     */
    static public function fromConfig(array $config = array(), array $defaults = array(), array $required = array())
    {
        throw new RuntimeException(get_called_class() . ' cannot be instantiated statically.');
    }

    /**
     * Returns an array of keys and the default values for this Hash.
     * @see \Guzzle\Common\Collection::setDefaults()
     * @return array
     * @deprecated Will be removed in 0.5.0
     */
    public function getDefaults()
    {
        return $this->defaults;
    }

    /**
     * Returns an array of required keys for this Hash.
     * @see \Guzzle\Common\Collection::setRequired()
     * @return array
     * @deprecated Will be removed in 0.5.0
     */
    public function getRequired()
    {
        return $this->required;
    }

    /**
     * Returns an array of optional keys for this Hash.
     * @see \Guzzle\Common\Collection::setOptional()
     * @return array
     * @deprecated Will be removed in 0.5.0
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * {@inheritDoc}
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    protected function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults($this->defaults);
        $resolver->setRequired($this->required);
        $resolver->setOptional($this->optional);
    }
}
