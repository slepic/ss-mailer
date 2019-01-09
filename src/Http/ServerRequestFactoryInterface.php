<?php

namespace SsMailer\Http;

use Psr\Http\Message\ServerRequestInterface;

interface ServerRequestFactoryInterface
{
    public function createServerRequest(): ServerRequestInterface;
}
