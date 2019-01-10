<?php

namespace SsMailer\Model\Send;

interface RequestInterface
{
    public function hasErrors(): bool;
    public function getErrors(): array;
    public function getEmailRequest(): EmailRequestInterface;
}
