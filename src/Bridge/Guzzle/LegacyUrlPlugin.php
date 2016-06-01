<?php

namespace Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Common\Event;
use Guzzle\Http\Message\RequestInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class LegacyUrlPlugin implements EventSubscriberInterface
{
    const BASE_URL = '%s.slack.com';
    const WEBHOOK_PATH = '/services/hooks/incoming-webhook';

    private $username;
    private $token;

    /**
     * @param $username
     * @param $token
     */
    public function __construct($username, $token)
    {
        $this->username = $username;
        $this->token = $token;
    }

    /**
     * @see EventSubscriberInterface
     */
    public static function getSubscribedEvents()
    {
        return [
            'request.before_send' => ['onRequestBeforeSend', -1000],
        ];
    }

    /**
     * @param Event $e
     */
    public function onRequestBeforeSend(Event $e)
    {
        /** @var RequestInterface $request */
        $request = $e['request'];

        $url = $request->getUrl(true)
            ->setScheme('https')
            ->setHost(sprintf(self::BASE_URL, $this->username))
            ->setPath(self::WEBHOOK_PATH);

        $request->setUrl($url)
            ->getQuery()
            ->add('token', $this->token);
    }
}
