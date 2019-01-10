<?php

namespace SsMailer\Model\Send;

interface SenderInterface
{
    public function sendEmail(RequestInterface $request): ResponseInterface;
}
