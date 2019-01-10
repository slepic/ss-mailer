<?php

namespace SsMailer\Model\Send;

interface ResponseInterface
{
    public function getStatus(): bool;

    public function getMessageId(): ?string;

    public function getErrors(): array;
}
