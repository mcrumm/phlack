<?php

namespace Crummy\Phlack\Message;

use Crummy\Phlack\Common\Encodable;

class SlashCommand implements Encodable
{
    private $token;
    private $teamId;
    private $channelId;
    private $channelName;
    private $userId;
    private $userName;
    private $command;
    private $text;

    /**
     * @param array $parameters
     */
    public function __construct($parameters = array())
    {
        if (is_array($parameters) || $parameters instanceof \Traversable) {
            foreach ($parameters as $parameter => $value) {
                $setter = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $parameter)));
                if (method_exists($this, $setter)) {
                    $this->{$setter}($value);
                }
            }
        }
    }

    /**
     * {@inheritDoc}
     */
    public function jsonSerialize()
    {
        return [
            'token' => $this->token,
            'team_id' => $this->teamId,
            'channel_id' => $this->channelId,
            'channel_name' => $this->channelName,
            'user_id'      => $this->userId,
            'user_name'    => $this->userName,
            'command'      => $this->command,
            'text'         => $this->text
        ];
    }

    public function __toString()
    {
        return json_encode($this);
    }

    /**
     * @param string $method
     * @return Command
     * @throws \InvalidArgumentException
     */
    static public function createFromGlobal($method = 'POST')
    {
        $method = strtoupper($method);
        if (!in_array($method, [ 'POST', 'GET' ])) {
            throw new \InvalidArgumentException(sprintf('Method must be one of POST or GET, got "%s"', $method));
        }

        $parameters = ($method === 'POST') ? $_POST : $_GET;
        return new self($parameters);
    }

    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setTeamId($teamId)
    {
        $this->teamId = $teamId;
        return $this;
    }

    public function getTeamId()
    {
        return $this->teamId;
    }

    public function setChannelId($channelId)
    {
        $this->channelId = $channelId;
        return $this;
    }

    public function getChannelId()
    {
        return $this->channelId;
    }

    public function setChannelName($channelName)
    {
        $this->channelName = $channelName;
        return $this;
    }

    public function getChannelName()
    {
        return $this->channelName;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
        return $this;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    public function getCommand()
    {
        return $this->command;
    }

    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    public function getText()
    {
        return $this->text;
    }
}
