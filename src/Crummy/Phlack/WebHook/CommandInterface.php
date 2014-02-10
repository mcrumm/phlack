<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Encodable;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

interface CommandInterface extends Encodable
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver);

    /**
     * @return string
     */
    public function getChannelName();

    /**
     * @return string
     */
    public function getChannelId();

    /**
     * @return string
     */
    public function getCommand();

    /**
     * @return string
     */
    public function getTeamId();

    /**
     * @return string
     */
    public function getText();

    /**
     * @return string
     */
    public function getToken();

    /**
     * @return string
     */
    public function getUserName();

    /**
     * @return string
     */
    public function getUserId();

    /**
     * @return array
     */
    public function toArray();
}
