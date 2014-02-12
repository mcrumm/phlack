<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Hash;

class AbstractCommand extends Hash implements CommandInterface
{
    protected $required = [
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
     * {@inheritDoc}
     */
    public function getChannelName()
    {
        return $this->data['channel_name'];
    }

    /**
     * {@inheritDoc}
     */
    public function getChannelId()
    {
        return $this->data['channel_id'];
    }

    /**
     * {@inheritDoc}
     */
    public function getCommand()
    {
        return $this->data['command'];
    }

    /**
     * {@inheritDoc}
     */
    public function getTeamId()
    {
        return $this->data['team_id'];
    }

    /**
     * {@inheritDoc}
     */
    public function getText()
    {
        return $this->data['text'];
    }

    /**
     * {@inheritDoc}
     */
    public function getToken()
    {
        return $this->data['token'];
    }

    /**
     * {@inheritDoc}
     */
    public function getUserName()
    {
        return $this->data['user_name'];
    }

    /**
     * {@inheritDoc}
     */
    public function getUserId()
    {
        return $this->data['user_id'];
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
        return $this->data;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->data;
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
