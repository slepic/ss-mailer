<?php

namespace SsMailer\Http;

use SsMailer\Http\ResponseSenderInterface;
use Psr\Http\Message\ResponseInterface;
use function Http\Response\send;

class HttpInteropResponseSender implements ResponseSenderInterface
{
    public function sendResponse(ResponseInterface $response): void
    {
        send($response);
    }
}
