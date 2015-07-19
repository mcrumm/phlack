<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\Exception\RuntimeException;
use Crummy\Phlack\Common\OptionsResolver;
use Symfony\Component\OptionsResolver\Options;

class WebHook extends AbstractCommand implements WebHookInterface
{
    const COMMAND_DELIMITER = ':';

    protected $required = [
        'token',
        'team_id',
        'team_domain',
        'service_id',
        'channel_id',
        'channel_name',
        'timestamp',
        'user_id',
        'user_name',
        'text'
    ];

    /**
     * @param OptionsResolver $resolver
     */
    protected function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefaults([
            'command' => function(Options $options) {
                $text         = $options['text'];
                $delimiterPos = strpos($text, self::COMMAND_DELIMITER);
                $delimiterPos = false === $delimiterPos ? strpos($text, ' ') : $delimiterPos;

                return false === $delimiterPos ? $text : substr($text, 0, $delimiterPos);
            }
        ]);

        $resolver->setNormalizers([
            'command' => function (Options $options, $value) {
                if (null !== $value) {
                    $value = preg_replace('/[^a-z0-9\-]/', '', strtolower($value));
                    if (false === strpos($value, self::COMMAND_DELIMITER)) {
                        $value .= self::COMMAND_DELIMITER;
                    }
                }
                return $value;
            }
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getTimestamp()
    {
        return $this->data['timestamp'];
    }

    /**
     * @return void
     * @throws \Crummy\Phlack\Common\Exception\RuntimeException
     */
    static public function fromGet()
    {
        throw new RuntimeException('GET requests from WebHooks are not allowed.');
    }
}
