<?php

namespace SsMailer\Model\Send;

use SsMailer\Model\ErroneousInterface;

interface ResponseInterface extends ErroneousInterface
{
    public function getMessageId(): ?string;
}
