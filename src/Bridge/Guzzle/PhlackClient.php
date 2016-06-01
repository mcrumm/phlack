<?php

namespace Crummy\Phlack\Bridge\Guzzle;

use Guzzle\Common\Collection;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class PhlackClient extends Client
{
    /** @var array */
    protected $defaultConfig = [
        'request.options' => [
            'exceptions'  => false,
        ],
    ];

    /** @var array */
    protected $legacyRequirements = ['username', 'token'];

    /**
     * @param string     $baseUrl
     * @param array|null $config
     */
    public function __construct($baseUrl = LegacyUrlPlugin::BASE_URL, $config = null)
    {
        $legacyMode = $this->isLegacyUrl($baseUrl);

        $config = Collection::fromConfig(
            $config ?: [],
            $this->defaultConfig,
            $legacyMode ? $this->legacyRequirements : []
        );

        if ($legacyMode) {
            $this->addSubscriber(new LegacyUrlPlugin($config['username'], $config['token']));
            unset($config['username'], $config['token']);
        }

        parent::__construct($baseUrl, $config);

        $this->setDescription(ServiceDescription::factory(__DIR__.'/Resources/slack.json'));
    }

    /**
     * {@inheritdoc}
     */
    public static function factory($config = [])
    {
        if (!is_array($config)) {
            return new self($config);
        }

        return new self(isset($config['url']) ? $config['url'] : null, $config);
    }

    /**
     * @param string $baseUrl
     *
     * @return bool
     */
    private function isLegacyUrl($baseUrl)
    {
        return null === $baseUrl || $baseUrl === LegacyUrlPlugin::BASE_URL;
    }
}
