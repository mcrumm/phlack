<?php

namespace Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\Bot\Mainframe\Adapter\AbstractAdapter;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleAdapter extends AbstractAdapter
{
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $in = $input->getArgument('command');
        $text = is_array($in) ? implode(' ', $in) : $in;
        $command = call_user_func($this->converter, $text);
        $result = $this->mainframe->execute($command);
        var_dump($result);
        $output->writeln($result);
    }
}
