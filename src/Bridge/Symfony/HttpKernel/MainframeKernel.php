<?php

namespace Crummy\Phlack\Bridge\Symfony\HttpKernel;

use Crummy\Phlack\Bridge\Symfony\HttpFoundation\RequestConverter;
use Crummy\Phlack\WebHook\MainframeInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class MainframeKernel implements HttpKernelInterface
{
    /**
     * @var MainframeInterface
     */
    protected $mainframe;

    /**
     * @var RequestConverter
     */
    protected $converter;

    /**
     * MainframeKernel constructor.
     *
     * @param MainframeInterface $mainframe
     */
    public function __construct(MainframeInterface $mainframe)
    {
        $this->mainframe = $mainframe;
        $this->converter = new RequestConverter();
    }

    /**
     * Mediates Request handling between HttpKernelInterface and the Mainframe.
     * {@inheritdoc}
     */
    public function handle(Request $request, $type = self::MASTER_REQUEST, $catch = true)
    {
        $convert = $this->converter;
        $command = $convert($request);
        $message = $this->mainframe->execute($command);

        return new Response($message);
    }
}
