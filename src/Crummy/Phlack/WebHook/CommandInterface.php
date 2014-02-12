<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Encodable;
use Guzzle\Common\ToArrayInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * CommandInterface
 */
interface CommandInterface extends Encodable, ToArrayInterface
{
    /**
     * @param $key
     * @return mixed
     */
    public function get($key);

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getChannelName();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getChannelId();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getCommand();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getTeamId();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getText();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getToken();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getUserName();

    /**
     * @return string
     * @deprecated Will be removed in 0.5.0
     */
    public function getUserId();
}
