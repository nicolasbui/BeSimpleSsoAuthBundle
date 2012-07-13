<?php

namespace BeSimple\SsoAuthBundle\Tests;

use Buzz\Client\ClientInterface;
use Buzz\Message\MessageInterface;
use Buzz\Message\RequestInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class HttpClient implements ClientInterface
{
    static protected $kernel;

    static public function setKernel(Kernel $kernel)
    {
        static::$kernel = $kernel;
    }

    function send(RequestInterface $buzzRequest, MessageInterface $buzzResponse)
    {
        $session  = session_id();
        $request  = Request::create($buzzRequest->getUrl(), $buzzRequest->getMethod());
        $response = static::$kernel->handle($request);

        $buzzResponse->setContent($response->getContent());

        // kernel handling set session_id to empty string
        session_id($session);
    }

    public function setTimeout($timeout)
    {
    }

    public function setMaxRedirects($maxRedirects)
    {
    }
}
