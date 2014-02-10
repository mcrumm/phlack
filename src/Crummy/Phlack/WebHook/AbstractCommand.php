<?php

namespace Crummy\Phlack\WebHook;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AbstractCommand implements CommandInterface
{
    protected $options = [ ];

    protected $requiredFields = [
        'token',
        'team_id',
        'channel_id',
        'channel_name',
        'user_id',
        'user_name',
        'command',
        'text'
    ];

    /**
     * @param array $options
     */
    public function __construct(array $options = [ ])
    {
        $resolver = new OptionsResolver();
        $this->setDefaultOptions($resolver);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired($this->requiredFields);
    }

    /**
     * @return string
     */
    public function getChannelName()
    {
        return $this->options['channel_name'];
    }

    /**
     * @return string
     */
    public function getChannelId()
    {
        return $this->options['channel_id'];
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->options['command'];
    }

    /**
     * @return string
     */
    public function getTeamId()
    {
        return $this->options['team_id'];
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->options['text'];
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->options['token'];
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->options['user_name'];
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->options['user_id'];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->options;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->options;
    }

    /**
     * @return static
     */
    static public function fromPost()
    {
        return new static($_POST);
    }

    /**
     * @return static
     */
    static public function fromGet()
    {
        return new static($_GET);
    }
}
