<?php

namespace Crummy\Phlack\Bridge\Symfony\Console;

use Crummy\Phlack\WebHook\Converter\StringConverter;
use Crummy\Phlack\WebHook\Mainframe;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ConsoleAdapter extends Command
{
    /**
     * @var StringConverter
     */
    protected $converter;

    /**
     * @var Mainframe
     */
    protected $mainframe;

    /**
     * ConsoleAdapter constructor.
     *
     * @param Mainframe     $mainframe
     * @param callable|null $converter
     */
    public function __construct(Mainframe $mainframe, callable $converter = null)
    {
        $this->mainframe = $mainframe;
        $this->converter = $converter ?: new StringConverter();

        parent::__construct('phlack');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $in = $input->getArgument('command');
        $text = is_array($in) ? implode(' ', $in) : $in;

        $converter = $this->converter;
        $command = $converter($text);

        $message = $this->mainframe->execute($command);
        if (null !== $message) {
            $output->writeln($message['text']);
        }
    }
}
