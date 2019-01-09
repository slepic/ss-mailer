<?php

namespace SsMailer\Http;

use SsMailer\Http\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;

class ZendServerRequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(): ServerRequestInterface
    {
        return ServerRequestFactory::fromGlobals();
    }
}
