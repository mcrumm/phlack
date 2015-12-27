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
        'text',
    ];

    /**
     * {@inheritdoc}
     */
    public function getChannelName()
    {
        return $this->data['channel_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getChannelId()
    {
        return $this->data['channel_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getCommand()
    {
        return $this->data['command'];
    }

    /**
     * {@inheritdoc}
     */
    public function getTeamId()
    {
        return $this->data['team_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function getText()
    {
        return $this->data['text'];
    }

    /**
     * {@inheritdoc}
     */
    public function getToken()
    {
        return $this->data['token'];
    }

    /**
     * {@inheritdoc}
     */
    public function getUserName()
    {
        return $this->data['user_name'];
    }

    /**
     * {@inheritdoc}
     */
    public function getUserId()
    {
        return $this->data['user_id'];
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
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return static
     */
    public static function fromPost()
    {
        return new static($_POST);
    }

    /**
     * @return static
     */
    public static function fromGet()
    {
        return new static($_GET);
    }
}
