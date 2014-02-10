<?php

namespace Crummy\Phlack\Common;

use Crummy\Phlack\Common\Exception\RuntimeException;
use Guzzle\Common\Collection as GuzzleCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class Hash extends GuzzleCollection implements Encodable
{
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
     */
    public function getDefaults()
    {
        return [];
    }

    /**
     * Returns an array of required keys for this Hash.
     * @see \Guzzle\Common\Collection::setRequired()
     * @return array
     */
    public function getRequired()
    {
        return [];
    }

    /**
     * Returns an array of optional keys for this Hash.
     * @see \Guzzle\Common\Collection::setOptional()
     * @return array
     */
    public function getOptional()
    {
        return [];
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
        $resolver->setDefaults($this->getDefaults());
        $resolver->setRequired($this->getRequired());
        $resolver->setOptional($this->getOptional());
    }
}
