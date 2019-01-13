<?php

namespace SsMailer\Http;

use SsMailer\Http\ServerRequestFactoryInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\PhpInputStream;

class ZendServerRequestFactory implements ServerRequestFactoryInterface
{
    public function createServerRequest(): ServerRequestInterface
    {
        return ServerRequestFactory::fromGlobals();
    }
}
