<?php

namespace SsMailer\Http;

use Psr\Http\Message\ResponseInterface;

interface ResponseSenderInterface
{
    public function sendResponse(ResponseInterface $response): void;
}
