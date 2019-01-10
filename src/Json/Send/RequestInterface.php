<?php

namespace SsMailer\Json\Send;

use SsMailer\Model\Send\RequestInterface as EmailRequestInterface;

interface RequestInterface
{
    public function hasErrors(): bool;

    public function getErrors(): array;

    public function getEmailRequest(): EmailRequestInterface;
}
