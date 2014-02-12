<?php

namespace Crummy\Phlack\WebHook;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SlashCommand extends AbstractCommand
{
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);

        $resolver->setOptional([ 'team_domain', 'service_id' ]);
    }
}
