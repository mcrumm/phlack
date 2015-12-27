<?php

namespace Crummy\Phlack\WebHook;

use Crummy\Phlack\Common\OptionsResolver;

class SlashCommand extends AbstractCommand
{
    public function setDefaultOptions(OptionsResolver $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setDefined(['team_domain', 'service_id']);
    }
}
